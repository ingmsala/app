<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Seguimiento;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\SeguimientoSearch;
use app\modules\optativas\models\MatriculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SeguimientoController implements the CRUD actions for Seguimiento model.
 */
class SeguimientoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,8]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13]);
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
     * Lists all Seguimiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){

            $dataProvider = $searchModel->alumnosxcomision($com);
            
            $seguimientos = Seguimiento::find()
                
                ->joinWith('matricula0')
                ->where(['matricula.comision' =>$com])
                ->all();

            return $this->render('index', [
                
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'seguimientos' => $seguimientos,

            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Displays a single Seguimiento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $this->layout = 'main';
        $matricula = $id;
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
            $searchModel = new SeguimientoSearch();
            $dataProvider = $searchModel->seguimientosdelalumno($matricula);
            $matr = Matricula::findOne($matricula);
            
            return $this->render('view', [
                'matricula' => $matricula,
                'dataProvider' => $dataProvider,
                'matr' => $matr,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Creates a new Seguimiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        
        $this->layout = 'main';
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
            $model = new Seguimiento();
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d");
            $model->matricula = $id;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->matricula]);
            }

            return $this->render('create', [
                'model' => $model,
                'matr' => Matricula::findOne($id),
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Updates an existing Seguimiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $this->layout = 'main';
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->matricula]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Deletes an existing Seguimiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $this->layout = 'main';
        $model = $this->findModel($id);
        $matricula = $model->matricula;
        $model->delete();

        return $this->redirect(['view', 'id' => $matricula]);
    }

    /**
     * Finds the Seguimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguimiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
