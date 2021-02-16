<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Tutor;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Areasolicitud;
use app\modules\edh\models\Caso;
use app\modules\edh\models\Estadosolicitud;
use app\modules\edh\models\Plancursado;
use Yii;
use app\modules\edh\models\Solicitudedh;
use app\modules\edh\models\SolicitudedhSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SolicitudedhController implements the CRUD actions for Solicitudedh model.
 */
class SolicitudedhController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'cambiarestado', 'expediente'],
                'rules' => [
                    
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = Caso::findOne(Yii::$app->request->queryParams['id']);

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                

                                $jefe = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

                                if ($caso->jefe == $jefe->id)
                                     return true;
                            }

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){

                                $prece = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                        
                                if ($caso->preceptor == $prece->id)
                                     return true;
                            
                            }

                            return false;

                        }

                    ],
                    [
                        'actions' => ['create', 'update', 'expediente'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['cambiarestado'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_VICEACAD]);
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
     * Lists all Solicitudedh models.
     * @return mixed
     */
    public function actionIndex($id, $sol = 0)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = Caso::findOne($id);
        $searchModel = new SolicitudedhSearch();
        $dataProvider = $searchModel->porCaso($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'sol' => $sol,
        ]);
    }

    /**
     * Displays a single Solicitudedh model.
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

    public function actionCambiarestado($id, $est)
    {
        
        $model = $this->findModel($id);
        if($model->caso0->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        $estadosolicitudes = Estadosolicitud::find()->where(['in', 'id', [3,4]])->all();
        $model->estadosolicitud = $est;
        $model->scenario = $model::SCENARIO_STATE;

                
        if ($model->load(Yii::$app->request->post())) {
            
            $model->save();

            if($est == 3){
                $lbl = 'Aceptación de la solicitud del caso';
                $newmain = new Plancursado();
                $newmain = $newmain->nuevoPlanPrincipal($model->caso);
                
            }else
                $lbl = 'Rechazo de la solicitud del caso';

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->caso, 3, $lbl, 1);

            Yii::$app->session->setFlash('success', 'Se actualizó correctamente la solicitud');
            return $this->redirect(['index', 'id' => $model->caso]);

        }

        return $this->renderAjax('cambiarestado', [
            'model' => $model,
            'estadosolicitudes' => $estadosolicitudes,
            
        ]);
    }

    public function actionExpediente($id)
    {
        
        $model = $this->findModel($id);
        if($model->caso0->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        $model->scenario = $model::SCENARIO_ABM;
        
        if ($model->load(Yii::$app->request->post())) {

            $expedienteexplode = explode("/",$model->fechaexpediente);
            $newdateexpediente = date("Y-m-d", mktime(0, 0, 0, $expedienteexplode[1], $expedienteexplode[0], $expedienteexplode[2]));
            $model->fechaexpediente = $newdateexpediente;
            $model->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->caso, 3, 'Se registra expediente de la solicitud', 1);
            Yii::$app->session->setFlash('success', 'Se actualizó correctamente la solicitud');
            return $this->redirect(['index', 'id' => $model->caso]);

        }

        $fechaexpedienteexplode = explode("-",$model->fechaexpediente);
        $newdatefechaexpediente = (!empty($model->fechaexpediente)) ? date("d/m/Y", mktime(0, 0, 0, $fechaexpedienteexplode[1], $fechaexpedienteexplode[2], $fechaexpedienteexplode[0])) : null;
        $model->fechaexpediente = $newdatefechaexpediente;

        return $this->renderAjax('expediente', [
            'model' => $model,
            
        ]);
    }

    
    /**
     * Creates a new Solicitudedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $caso = Caso::findOne($id);
        if($caso->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        $model = new Solicitudedh();
        $model->scenario = $model::SCENARIO_ABM;
        $model->caso = $id;
        $model->estadosolicitud = 1;
        $model->tiposolicitud = 2;

        $areas = Areasolicitud::find()->all();
        $demandantes = Tutor::find()->where(['alumno' => $caso->matricula0->alumno])->all();


        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            if($model->fechaexpediente != null){
                $expedienteexplode = explode("/",$model->fechaexpediente);
                $newdateexpediente = date("Y-m-d", mktime(0, 0, 0, $expedienteexplode[1], $expedienteexplode[0], $expedienteexplode[2]));
                $model->fechaexpediente = $newdateexpediente;
            }
            $model->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->caso, 3, 'Se crea una solicitud de renovación del caso', 1);


            Yii::$app->session->setFlash('success', 'Se creó correctamente la solicitud');
            return $this->redirect(['index', 'id' => $id]);
        }

        
        return $this->renderAjax('create', [
            'model' => $model,
            'areas' => $areas,
            'demandantes' => $demandantes,
        ]);
    }

    /**
     * Updates an existing Solicitudedh model.
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
     * Deletes an existing Solicitudedh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $solicitud = $this->findModel($id);
        if($solicitud->caso0->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        $caso = $solicitud->caso;
        $solicitud->delete();

        return $this->redirect(['index', 'id' => $caso]);
    }

    /**
     * Finds the Solicitudedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitudedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicitudedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
