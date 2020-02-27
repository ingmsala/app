<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Acta;
use app\modules\optativas\models\Clase;
use app\modules\optativas\models\Detalletardanza;
use app\modules\optativas\models\Inasistencia;
use app\modules\optativas\models\InasistenciaSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * InasistenciaController implements the CRUD actions for Inasistencia model.
 */
class InasistenciaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'procesarausentes'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'procesarausentes'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            
                            
                            try{

                                $clase = Clase::findOne($_POST['clase']);
                                                                
                                if(
                                    count(Acta::find()->where(['comision' => $clase->comision])->andWhere(['estadoacta' => 2])->all()) > 0){
                                    Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                    return false;
                                }
                                return in_array (Yii::$app->user->identity->role, [1,8,9]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Inasistencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new InasistenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inasistencia model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'main';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inasistencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Inasistencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inasistencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inasistencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionProcesarausentes()
    {
        
        $param = Yii::$app->request->post();
        //return var_dump($param['keys2']);
        
        $presentes = explode(",", $param['presentes']);
        $tardanzas = json_decode($param['tardanzas']);
        $tardanzas = explode(",", $param['tardanzas']);
        
        //return $tardanzas;
        $clase = $param['clase'];
        //return $param['clase'][0];

        $clase = intval($clase);
        
        foreach ($presentes as $presente) {
            
            $existe2 = Inasistencia::find()
                ->select('id')
                ->where(['clase' => $clase])
                ->andWhere(['matricula' => $presente])
                ->count();
            

            if($existe2>0){
                $inasistenciax = Inasistencia::find()
                    ->select('id')
                    ->where(['clase' => $clase])
                    ->andWhere(['matricula' => $presente])
                    ->one();
                $this->findModel($inasistenciax->id)->delete();
            }

            $existe3 = Detalletardanza::find()
                ->select('id')
                ->where(['clase' => $clase])
                ->andWhere(['matricula' => $presente])
                ->count();
            

            if($existe3>0){
                $tardanzax = Detalletardanza::find()
                    ->select('id')
                    ->where(['clase' => $clase])
                    ->andWhere(['matricula' => $presente])
                    ->one();
                $this->findTardanza($tardanzax->id)->delete();
            }

           
        }
        $c = 0;
        foreach ($param['id'] as $matricula) {
                
                $model = new Inasistencia();
                $model->clase = $clase;
                $model->matricula = $matricula;
                if ($model->save())
                    $c=$c+1;
            

            
        }

        foreach ($param['keys2'] as $tardanza2) {
            $tardanzasactivas = explode(" - ", $tardanza2); 
            $model = new Detalletardanza();
            $model->clase = $clase;
            $model->matricula = $tardanzasactivas[0];
            $model->tardanza = $tardanzasactivas[1];
            if ($model->save())
                $c=$c+1;
        

        
    }

        Yii::$app->session->set('info', '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> La asistencia se cargó correctamente.<br/><b>Total: '.$c.' ausentes</b>');

        return $clase;
    }

    /**
     * Finds the Inasistencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inasistencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inasistencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findTardanza($id)
    {
        if (($model = Detalletardanza::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
