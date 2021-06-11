<?php

namespace app\modules\sociocomunitarios\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\Seguimiento;
use app\modules\sociocomunitarios\models\Calificacionrubrica;
use Yii;
use app\modules\sociocomunitarios\models\Detallerubrica;
use app\modules\sociocomunitarios\models\DetallerubricaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetallerubricaController implements the CRUD actions for Detallerubrica model.
 */
class DetallerubricaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'new'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'new'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                
                                if(in_array (Yii::$app->user->identity->role, [1,8])){
                                    $autoriza = false;
                                     if(in_array (Yii::$app->user->identity->role, [1])){
                                         return true;
                                    }
                                    if($_GET['r'] == 'sociocomunitarios/seguimiento/create')
                                        $matricula = Matricula::findOne(Yii::$app->request->queryParams['id']);
                                    elseif($_GET['r'] == 'sociocomunitarios/detallerubrica/new')
                                        $matricula = Seguimiento::findOne(Yii::$app->request->post()['id'])->matricula0;
                                    else
                                        $matricula = Seguimiento::findOne(Yii::$app->request->queryParams['id'])->matricula0;
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                        ->where(['comision' => $matricula->comision])
                                                        ->andWhere(['agente' => $agente->id])
                                                        ->all());
                                        if($cant>0){
                                            $autoriza = true;
                                        }

                                   
                                    

                                    if(
                                        count(Acta::find()->where(['comision' => $matricula->comision])->andWhere(['estadoacta' => 2])->all()) > 0){
                                        Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                        $autoriza = false;
                                    }
                                    return $autoriza;
                                }
                                return false;
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,20, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [1,3,6,12,13, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [8,9])){
                                    $matricula = Matricula::findOne(Yii::$app->request->queryParams['id']);
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $matricula->comision])
                                                    ->andWhere(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }
                                }
                                    
                                
                                
                                return false;
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
     * Lists all Detallerubrica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetallerubricaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detallerubrica model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Detallerubrica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Detallerubrica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionNew(){

        $seguimiento= Yii::$app->request->post()['seguimiento'];
        $calificacion= Yii::$app->request->post()['calificacion'];

        $cali = Calificacionrubrica::findOne($calificacion);

        $dr = Detallerubrica::find()
            ->joinWith(['calificacionrubrica0'])
            ->where(['seguimiento' => $seguimiento])
            ->andWhere(['calificacionrubrica.rubrica' => $cali->rubrica])
            ->one();
        
        if($dr==null){
            $model = new Detallerubrica();
            $model->seguimiento = $seguimiento;
            $model->calificacionrubrica = $calificacion;
            $model->save();
        }else{
            $model = $dr;

            if($model->seguimiento == $seguimiento && $model->calificacionrubrica == $calificacion){
                $model->delete();
            }else{
                $model->seguimiento = $seguimiento;
                $model->calificacionrubrica = $calificacion;
                $model->save();
            }
        }
            
        

    }

    /**
     * Updates an existing Detallerubrica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Detallerubrica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Detallerubrica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detallerubrica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detallerubrica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
