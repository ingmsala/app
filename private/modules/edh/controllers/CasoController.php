<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Tutor;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Areasolicitud;
use Yii;
use app\modules\edh\models\Caso;
use app\modules\edh\models\CasoSearch;
use app\modules\edh\models\Condicionfinal;
use app\modules\edh\models\Estadocaso;
use app\modules\edh\models\Matriculaedh;
use app\modules\edh\models\Solicitudedh;
use app\modules\edh\models\Tiposolicitud;
use kartik\form\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * CasoController implements the CRUD actions for Caso model.
 */
class CasoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'addreferente', 'addpreceptor', 'addjefe', 'cerrar', 'matriculas', 'demandantes', 'actualizar'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_PRECEPTOR, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_COORDINACION, Globales::US_VICEACAD]);
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
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_REGENCIA, Globales::US_COORDINACION, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = $this->findModel(Yii::$app->request->queryParams['id']);

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
                        'actions' => ['create', 'matriculas', 'demandantes', 'addreferente', 'addpreceptor', 'addjefe', 'actualizar'],   
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
                        'actions' => ['cerrar'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_REGENCIA]);
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
     * Lists all Caso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        

        /*
            busqueda
        */
        $model = new Caso();
        $param = Yii::$app->request->queryParams;
        $model->scenario = $model::SCENARIO_SEARCHINDEX;

        $aniolectivos = Aniolectivo::find()->all();
        $casos = Caso::find()->all();
        $estadoscaso = Estadocaso::find()->all();
        $alumnos = Alumno::find()->all();

        $searchModel = new CasoSearch();
        $dataProvider = $searchModel->search($param);

        if(isset($param['Caso']['aniolectivo']))
            $model->aniolectivo = $param['Caso']['aniolectivo'];
        if(isset($param['Caso']['resolucion']))
            $model->resolucion = $param['Caso']['resolucion'];
        if(isset($param['Caso']['alumno']))
            $model->alumno = $param['Caso']['alumno'];
        if(isset($param['Caso']['estadocaso']))
            $model->estadocaso = $param['Caso']['estadocaso'];
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'param' => $param,
            'model' => $model,
            'alumnos' => $alumnos,
            'estadoscaso' => $estadoscaso,
            'casos' => $casos,
            'aniolectivos' => $aniolectivos,
        ]);
    }

    /**
     * Displays a single Caso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Caso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = new Caso();
        $model->scenario = $model::SCENARIO_ABM;
        $modelSolicitud = new Solicitudedh();
        $modelSolicitud->scenario = $modelSolicitud::SCENARIO_ABM;

        $model->estadocaso = 1;
        $model->condicionfinal = 1;

        $modelSolicitud->tiposolicitud = 1;
        $modelSolicitud->estadosolicitud = 1;

        $aniolectivos = Aniolectivo::find()->all();
        $areas = Areasolicitud::find()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post()) && $modelSolicitud->load(Yii::$app->request->post())) {
           
            $desdeexplode = explode("/",$model->inicio);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->inicio = $newdatedesde;

            $finexplode = explode("/",$model->fin);
            $newdatefin = (!empty($model->fin)) ? date("Y-m-d", mktime(0, 0, 0, $finexplode[1], $finexplode[0], $finexplode[2])) : null;
            $model->fin = $newdatefin;

            $model->preceptor = $model->matricula0->division0->preceptor0->agente;
            $model->jefe = $model->matricula0->division0->jefe0->id;
            
            
            $model->save();

            $modelSolicitud->fecha = $model->inicio;
            $modelSolicitud->caso = $model->id;

            $modelSolicitud->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'modelSolicitud' => $modelSolicitud,
                'aniolectivos' => $aniolectivos,
                'areas' => $areas,
            ]);
        }
        return $this->render('creates', [
            'model' => $model,
            'modelSolicitud' => $modelSolicitud,
            'aniolectivos' => $aniolectivos,
            'areas' => $areas,
        ]);
    }

    public function actionAddreferente($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);
        
        $model->scenario = $model::SCENARIO_REFERENTE;
        

        $agentes = Agente::find()->orderBy('apellido, nombre')->all();
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        

        return $this->renderAjax('addreferente', [
            'model' => $model,
            'agentes' => $agentes,
        ]);
    }

    public function actionAddpreceptor($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);
        
        $model->scenario = $model::SCENARIO_PRECEPTOR;
        

        $agentes = Agente::find()->orderBy('apellido, nombre')->all();
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        

        return $this->renderAjax('addpreceptor', [
            'model' => $model,
            'agentes' => $agentes,
        ]);
    }

    public function actionAddjefe($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);
        
        $model->scenario = $model::SCENARIO_JEFE;
        

        $agentes = Agente::find()->orderBy('apellido, nombre')->all();
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        

        return $this->renderAjax('addjefe', [
            'model' => $model,
            'agentes' => $agentes,
        ]);
    }

    public function actionActualizar($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        if($model->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        
        $model->scenario = $model::SCENARIO_ABM;
        

        $condicionesfinales = Condicionfinal::find()->all();
        $estadoscaso = Estadocaso::find()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {

            
            
            $model->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->id, 2, 'Se modifica la resolución', 0);

           return $this->redirect(['view', 'id' => $model->id]);
        }

        

        return $this->renderAjax('actualizar', [
            'model' => $model,
            'estadoscaso' => $estadoscaso,
            'condicionesfinales' => $condicionesfinales,
        ]);
    }

    public function actionCerrar($id, $newestado)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        if($newestado == 1){
            $model->scenario = $model::SCENARIO_ABM;
            
            $ocultarfechafin = 1;
            $registro = 'Se reabre el caso, cerrado con fecha '. Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
            $model->fin = null;
            
        }else{
            $model->scenario = $model::SCENARIO_CERRAR;
            $ocultarfechafin = 0;
            $registro = 'Se cierra el caso, con fecha '.Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
        }
        
        $model->estadocaso = $newestado;
        $condicionesfinales = Condicionfinal::find()->all();
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->inicio);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->inicio = $newdatedesde;

            $finexplode = explode("/",$model->fin);
            $newdatefin = (!empty($model->fin)) ? date("Y-m-d", mktime(0, 0, 0, $finexplode[1], $finexplode[0], $finexplode[2])) : null;
            $model->fin = $newdatefin;

            $model->save();

            if($newestado != 1){
                $registro = 'Se cierra el caso, con fecha '.Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
            }

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->id, 2, $registro, 1);

           return $this->redirect(['view', 'id' => $model->id]);
        }

        $desdeexplode = explode("-",$model->inicio);
        $newdatedesde = (!empty($model->inicio)) ? date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0])) : null;
        $model->inicio = $newdatedesde;

        $finexplode = explode("-",$model->fin);
        $newdatefin = (!empty($model->fin)) ? date("d/m/Y", mktime(0, 0, 0, $finexplode[1], $finexplode[2], $finexplode[0])) : null;
        $model->fin = $newdatefin;

        return $this->renderAjax('cerrar', [
            'model' => $model,
            'ocultarfechafin' => $ocultarfechafin ,
            
            'condicionesfinales' => $condicionesfinales,
        ]);
    }

    

    /**
     * Updates an existing Caso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Caso model.
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

    public function actionMatriculas($id)
    {
        $aniolectivo_id = $id;
        $matriculas = Matriculaedh::find()->where(['aniolectivo' => $aniolectivo_id])->all();
        echo "<option>Seleccionar...</option>";
        foreach($matriculas as $matricula){
            echo "<option value='".$matricula->id."'>".$matricula->alumno0->apellido.', '.$matricula->alumno0->nombre.' ('.$matricula->division0->nombre.')'."</option>";
        }
        
        /*Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            
            if ($parents != null) {

                $aniolectivo_id = (int)$parents[0];

                $matriculas = Matriculaedh::find()->where(['aniolectivo' => $aniolectivo_id])->all();
                                
                $listMatriculas=ArrayHelper::toArray($matriculas, [
                    'app\modules\edh\models\Matriculaedh' => [
                        'id' => function($model) {
                            return $model['id'];},
                        'name' => function($model) {
                            return $model['alumno0']['apellido'].', '.$model['alumno0']['nombre'].' ('.$model['division0']['nombre'].')';},
                    ],
                ]);
                $out = $listMatriculas;
                
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];*/

        
        
        
    }

    public function actionDemandantes($id)
    {
        $matricula_id = $id;
        $matricula = Matriculaedh::findOne($matricula_id);
        $tutores = Tutor::find()->where(['alumno' => $matricula->alumno])->all();
        echo "<option>Seleccionar...</option>";
        foreach($tutores as $tutor){
            echo "<option value='".$tutor->id."'>".$tutor->apellido.', '.$tutor->nombre.' ('.$tutor->parentesco.')'."</option>";
        }

        /*Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {

            
            
            $parents = $_POST['depdrop_parents'];
            
            $matricula_id = empty($parents[1]) ? null : (int)$parents[1];
            //$matricula_id = $parents[0];
            
            if ($matricula_id != null) {

                

                $matricula = Matriculaedh::findOne($matricula_id);

                $tutores = Tutor::find()->where(['alumno' => $matricula->alumno])->all();
                                
                $listTutores=ArrayHelper::toArray($tutores, [
                    'app\modules\curriculares\models\Tutor' => [
                        'id' => function($model) {
                            return $model['id'];},
                        'name' => function($model) {
                            return $model['apellido'].', '.$model['nombre'].' ('.$model['parentesco'].')';},
                    ],
                ]);
                $out = $listTutores;
                
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];*/

        
        
        
    }

    /**
     * Finds the Caso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Caso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Caso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
