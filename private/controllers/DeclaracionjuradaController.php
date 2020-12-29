<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Actividadnooficial;
use Yii;
use app\models\Declaracionjurada;
use app\models\DeclaracionjuradaSearch;
use app\models\Diasemana;
use app\models\Agente;
use app\models\Funciondj;
use app\models\FunciondjSearch;
use app\models\Horariodj;
use app\models\Localidad;
use app\models\MensajedjSearch;
use app\models\Pasividaddj;
use app\models\Provincia;
use app\models\Tipodocumento;
use app\modules\curriculares\models\Aniolectivo;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * DeclaracionjuradaController implements the CRUD actions for Declaracionjurada model.
 */
class DeclaracionjuradaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'detalleagente', 'view', 'create', 'datospersonales', 'percepciones', 'cargos', 'horarios', 'actualizarpasividad', 'actualizarnooficial', 'resumen', 'print', 'update', 'delete', 'declaracionesjuradasadmin', 'cambiarestado'],
                'rules' => [
                    [
                        'actions' => ['delete', 'update', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index', 'update', 'create', 'resumen', 'print', 'datospersonales', 'percepciones', 'cargos', 'horarios', 'actualizarpasividad', 'actualizarnooficial'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_NODOCENTE, Globales::US_PRECEPTOR, Globales::US_MANTENIMIENTO]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['declaracionesjuradasadmin', 'detalleagente', 'resumen', 'print'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_SECRETARIA]);
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
                    'cambiarestado' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Declaracionjurada models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'mainpersonal';
        $searchModel = new DeclaracionjuradaSearch();
        //return Yii::$app->user->identity->username;
        $dataProvider = $searchModel->porAgente(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetalleagente($d)
    {
        $this->layout = 'main';
        $searchModel = new DeclaracionjuradaSearch();
        $dataProvider = $searchModel->porAgenteadmin($d);

        return $this->render('detalleagente', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Declaracionjurada model.
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
     * Creates a new Declaracionjurada model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'mainpersonal';
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($agente == null){
           
            Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
            return $this->redirect(['index']); 
            
        }

        $agente->scenario = Agente::SCENARIO_DECLARACIONJURADA;
        $cantidadabiertos = Declaracionjurada::find()
                                ->where(['agente' => $agente->documento])
                                ->andWhere(['or', 
                                    ['=', 'estadodeclaracion', 1],
                                    ['=', 'estadodeclaracion', 4],
                                ])
                                ->count();
        $cantidadenviados = Declaracionjurada::find()
                                ->where(['agente' => $agente->documento])
                                ->andWhere(['=', 'estadodeclaracion', 2])
                                ->count();
        
        if($cantidadabiertos > 0){
            Yii::$app->session->setFlash('danger', 'No puede iniciar una nueva Declaración Jurada ya que existe una en estado de <b>Pendiente de Envío</b>. Puede ingresar a la misma para modificarla y enviarla.');
            return $this->redirect(['index']);
        }elseif($cantidadenviados > 0){
            Yii::$app->session->setFlash('danger', 'No puede iniciar una nueva declaración ya que existe una en estado <b>Enviada</b>. Deberá esperar el procesamiento por parte de la Oficina de Personal.');
            return $this->redirect(['index']);
        }else{
            $model = new Declaracionjurada();
            $model->agente = $agente->documento;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d H:i:s");
            $model->estadodeclaracion = 1;
            $model->actividadnooficial = 0;
            $model->pasividad = 0;
            $model->save();

            return $this->redirect(['datospersonales']);
        }
        
    }

    public function actionPercepciones(){
        $this->layout = 'mainpersonal';
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($agente == null){
            
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            
        }
        $model = Declaracionjurada::find()->where(['agente' => $agente->documento])->andWhere(['or', 
                                            ['=', 'estadodeclaracion', 1],
                                            ['=', 'estadodeclaracion', 4],])->one();
        if($model == null){
            Yii::$app->session->setFlash('danger', "No tiene acceso a la Declaración Jurada");
            return $this->redirect(['index']);
        }
        //$model = Declaracionjurada::find()->where(['agente' => $agente->documento])->andWhere(['=', 'estadodeclaracion', 1])->one();
            date_default_timezone_set('America/Argentina/Buenos_Aires');

        $actividadnooficial = Actividadnooficial::find()->where(['declaracionjurada' => $model->id])->one();
        if($actividadnooficial == null){
            $actividadnooficial = new Actividadnooficial();
            $actividadnooficial->declaracionjurada = $model->id;
        }

        $pasividaddj = Pasividaddj::find()->where(['declaracionjurada' => $model->id])->one();
        if($pasividaddj == null){
            $pasividaddj = new Pasividaddj();
            $pasividaddj->declaracionjurada = $model->id;
        }
        $pasividaddj->scenario = Pasividaddj::SCENARIO_DECLARACIONJURADA; 
        
        if (Yii::$app->request->post()) {
            //return var_dump(Yii::$app->request->post());
            $validacion = true;
            $mensaje = '<b>Se detectaron los siguientes inconventientes:</b><u>';
            $model = Declaracionjurada::findOne($model->id);
            if(!$model->pasividad){
                //return var_dump(Yii::$app->request->post());
                try {
                    $pasividaddj->delete();
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }else{
                $pas = Pasividaddj::find()->where(['declaracionjurada' => $model->id])->count();
                if($pas == 0){
                    $validacion = false;
                    $mensaje .= "<li>Se declara que se percibe pasividad pero no completa los campos.</li>";
                    
                }
            }
            if(!$model->actividadnooficial){
                //return var_dump(Yii::$app->request->post());
                
                try {
                    $actividadnooficial->delete();
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }else{
                $actno = Actividadnooficial::find()->where(['declaracionjurada' => $model->id])->count();
                
                if($actno == 0){
                    $validacion = false;

                    $mensaje .= "<li>Se declara que se realiza una tarea o actividad no oficial pero no completa los campos.</li>";
                    
                }
            }
            if(!$validacion){
                    $mensaje .= '</u>';
                    Yii::$app->session->setFlash('danger', $mensaje);
                    
                    return $this->redirect(['percepciones']);
            }
            
            //return var_dump(Yii::$app->request->post());
            return $this->redirect(['horarios']);
        }
        
        return $this->render('percepciones', [
            'model' => $model,
            'agente' => $agente,
            'actividadnooficial' => $actividadnooficial,
            'pasividaddj' => $pasividaddj,
        ]);
    }

    public function actionDatospersonales(){
        $this->layout = 'mainpersonal';
        
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($agente == null){
            Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']);
        
        }

        try {
            $desdeexplode = explode("-",$agente->fechanac);
            $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
            $agente->fechanac = $newdatedesde;
        } catch (\Throwable $th) {
            
        }

        if($agente->localidad == null){
            $agente->localidad = 140077;
        }

        $domicilioanterior = $agente->domicilio;
        
        $agente->scenario = Agente::SCENARIO_DECLARACIONJURADA;
        $tipodocumento = Tipodocumento::find()->all();
        $localidad = Localidad::find()->orderBy('nombre')->all();
        $provincia = Provincia::find()->all();

        $model = Declaracionjurada::find()
                                ->where(['agente' => $agente->documento])
                                ->andWhere(['or', 
                                    ['=', 'estadodeclaracion', 1],
                                    ['=', 'estadodeclaracion', 4],
                                ])->one();
            date_default_timezone_set('America/Argentina/Buenos_Aires');

            if($model == null){
                Yii::$app->session->setFlash('danger', "No tiene acceso a la Declaración Jurada");
                return $this->redirect(['index']);
            }

        $model->fecha = date("Y-m-d H:i:s");
        $model->estadodeclaracion = 1;
        $model->save();
        

        if ($agente->load(Yii::$app->request->post())) {
            //return var_dump(Yii::$app->request->post());

            $desdeexplode = explode("/",$agente->fechanac);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $agente->fechanac = $newdatedesde;
            $agente->apellido = strtoupper($agente->apellido);
            $agente->nombre = strtoupper($agente->nombre);

            $agente->load(Yii::$app->request->post()['Agente']);
                $agente->save();
                if($agente->domicilio !=$domicilioanterior && $agente->mapuche == 1){
                    
                    $agente->mapuche = 2;
                    $agente->save();
                }
            
            //return var_dump(Yii::$app->request->post());
            return $this->redirect(['cargos']);
        }

        $searchModelmsj = new MensajedjSearch();
        $dataProviderMsj = $searchModelmsj->search($model->id);

        return $this->render('datospersonales', [
            'model' => $model,
            'agente' => $agente,
            'tipodocumento' => $tipodocumento,
            'localidad' => $localidad,
            'provincia' => $provincia,
            'dataProviderMsj' => $dataProviderMsj,
            
        ]);
    }
    public function actionCargos(){
        return $this->guardarCargos();
    }
    protected function guardarCargos(){
        $this->layout = 'mainpersonal';
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($agente == null){
            
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            
        }
        $listadofunciones = Funciondj::find()->all();
        $declaracionjurada = Declaracionjurada::find()->where(['agente' => $agente->documento])->andWhere(['or', 
            ['=', 'estadodeclaracion', 1],
            ['=', 'estadodeclaracion', 4],
        ])->one();

        if($declaracionjurada == null){
            Yii::$app->session->setFlash('danger', "No tiene acceso a la Declaración Jurada");
            return $this->redirect(['index']);
        }
        
        /*$model = new Funciondj();
        $model->declaracionjurada = $declaracionjurada->id;*/

        

        

        if (Yii::$app->request->post()) {
            
            if(Yii::$app->request->post()['btn_submit'] == 'add'){

                $searchModel2 = new FunciondjSearch();
                $dataProvider2 = $searchModel2->search($declaracionjurada->id);
                $models2 = $dataProvider2->getModels();

                $guardook2 = $this->GuardarModelos($models2);


                $model2 = new Funciondj();
                $model2->declaracionjurada = $declaracionjurada->id;
                $model2->dependencia = 'UNC';
                $model2->reparticion = 'Colegio Nacional de Monserrat';
                $model2->publico = 1;
                $model2->save();
            }
            if(Yii::$app->request->post()['btn_submit'] == 'ant')
                return $this->redirect(['datospersonales']);
            
        }
        
        $searchModel = new FunciondjSearch();
        $dataProvider = $searchModel->search($declaracionjurada->id);
        $models = $dataProvider->getModels();
       
        if(count($models)==0){
            if(!Yii::$app->params['devicedetect']['isMobile']){
                $model2 = new Funciondj();
                $model2->declaracionjurada = $declaracionjurada->id;
                $model2->dependencia = 'UNC';
                $model2->reparticion = 'Colegio Nacional de Monserrat';
                $model2->publico = 1;
                $model2->save();
            }

                $searchModel = new FunciondjSearch();
                $dataProvider = $searchModel->search($declaracionjurada->id);
                $models = $dataProvider->getModels();
        }    

        
            if (Funciondj::loadMultiple($models, Yii::$app->request->post()) && Funciondj::validateMultiple($models)) {
                //return var_dump($models);
                $guardook = $this->GuardarModelos($models);
                
                if($guardook){
                    /*if(Yii::$app->request->post()['btn_submit'] == 'add'){
                        $model2 = new Funciondj();
                        $model2->declaracionjurada = $declaracionjurada->id;
                        $model2->save();
                    }*/
                }else{
                    Yii::$app->session->setFlash('danger', "Para avanzar debe completar al menos un cargo y llenar todos los campos de los cargos actuales o borrar las filas sin uso");
                    return $this->redirect(['cargos']);
                }
                
                if(Yii::$app->request->post()['btn_submit'] == 'sig')
                    return $this->redirect(['percepciones']);
                elseif(Yii::$app->request->post()['btn_submit'] == 'ant'){
                    return $this->redirect(['datospersonales']);
                }
                elseif(Yii::$app->request->post()['btn_submit'] == 'add')
                    return $this->redirect(['cargos']);
            
            
        }

        $publicos = [1 => 'Pública', 2 => 'Privada'];
        $licencia = [1 => 'No', 2 => 'Sí'];

        return $this->render('cargos', [
            //'model' => $model,
            'listadofunciones' => $listadofunciones,
            'dataProvider' => $dataProvider,
            'publicos' => $publicos,
            'licencia' => $licencia,
            'declaracionjurada' => $declaracionjurada->id,

                        
        ]);
    }


    protected function GuardarModelos($models){
        $count = 0;
            $validacion = 0;
            foreach ($models as $index => $model0) {
                // populate and save records for each model
                $vacio = 0;
                if($model0->publico == 2){
                   
                    $model0->dependencia = null;
                }
                if(($model0->dependencia == null || $model0->dependencia == '') && $model0->publico == 1){
                    
                    $vacio++;
                }
                if($model0->reparticion == null || $model0->reparticion == ''){
                    
                    $vacio++;
                }
                if($model0->cargo == null || $model0->cargo == ''){
                    
                    $vacio++;
                }
                if($model0->horas == null || $model0->horas == ''){
                   
                    $vacio++;
                }
                

                if($vacio == 4){
                    //$model0->delete();
                    $validacion++;
                }elseif($vacio == 0){
                    $model0->save();
                }else{
                    $validacion++;
                }
           }     
                if($validacion>0){
                    return false;
                    
                }else{
                    return true;
                    }
    }

    public function actionHorarios(){
        $this->layout = 'mainpersonal';
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($agente == null){
            
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            
        }
        
        $declaracionjurada = Declaracionjurada::find()
                                ->where(['agente' => $agente->documento])
                                ->andWhere(['or', 
                                                ['=', 'estadodeclaracion', 1],
                                                ['=', 'estadodeclaracion', 4],
                                ])->one();

        if($declaracionjurada == null){
            Yii::$app->session->setFlash('danger', "No tiene acceso a la Declaración Jurada");
            return $this->redirect(['index']);
        }
        
        $horarios = Horariodj::find()
            ->joinWith(['funciondj0', 'funciondj0.declaracionjurada0'])
            //->where(['diasemana' => 2])
            ->andWhere(['funciondj.declaracionjurada' => $declaracionjurada->id])
            ->andWhere(['is', 'horariodj.actividadnooficial', null])
            ->orderBy('diasemana, inicio')
            ->all();
        //return var_dump($horarios);

        $funciones = Funciondj::find()
            ->where(['declaracionjurada' => $declaracionjurada->id])
            ->andWhere(['is not','cargo',null])
            ->all();
        $dias = Diasemana::find()->all();

        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        $lic = 0;
        foreach ($dias as $dia) {
            $ch = 0;
            foreach ($funciones as $funcion) {
                # code...
                if($cd == 0)
                if($funcion->licencia == 1)
                    $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.'</em>';
                else
                    $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.' - Licencia <span style="color:red">*</span></em>'; 
                if($funcion->licencia == 1){
                    
                    $array[$funcion->id][$dia->id] = Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['value' => Url::to('index.php?r=horariodj/create&dj='.$declaracionjurada->id.'&funcion='.$funcion->id.'&diasemana='.$dia->id), 'class' => 'btn btn-success amodalhorariojs']);
                }else{
                    $lic = 1;
                }
               
                $ch = $ch + 1;
            }
            $cd = $cd + 1;
        }

        $salida = '';
        foreach ($horarios as $horariox) {

            if($horariox->funciondj0->licencia == 1){
                 date_default_timezone_set('America/Argentina/Buenos_Aires');
                $array[$horariox->funciondj][$horariox->diasemana] .= '<br /><br /><div class="label label-info" style="border-style: solid;border-width: 1px;border-radius: 5px; font-size: 14px;">'.Yii::$app->formatter->asDate($horariox->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariox->fin, 'HH:mm').' '.
            Html::a('<span class="glyphicon glyphicon-remove"></span>', '?r=horariodj/delete&id='.$horariox->id, 
           ['class' => 'deletebuttonhorario',
               'data' => [
           'confirm' => '¿Está seguro de querer eliminar este elemento?',
           'method' => 'post',
            ]
           ]).'</div>';
            }
           
        }
        
        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);

        if (Yii::$app->request->post()) {
            
            if(count($funciones)>0){
                foreach ($funciones as $funcion) {
                    if($funcion->licencia == 1){
                        $canthorarios = Horariodj::find()->where(['funciondj' => $funcion->id])->count();
                        if($canthorarios==0){
                            Yii::$app->session->setFlash('danger', "Para continuar debe completar al menos un horario en todos los cargos que declaró sin licencia");
                            return $this->redirect(['horarios']);
                        }
                    }
                    
                }
            }else{
                Yii::$app->session->setFlash('danger', "Para continuar debe completar al menos un cargo");
                return $this->redirect(['cargos']);
            }
            return $this->redirect(['resumen', 'dj' => $declaracionjurada->id]);
        }

        return $this->render('horarios',[
            'provider' => $provider,
            'lic' => $lic,
        ]);

    }

    public function actionActualizarpasividad(){
        $param = Yii::$app->request->post();
        $model = $this->findModel($param['id']);
        $model->pasividad = $param['estado'];
        $model->save();
        return $param['estado'];
    }
    public function actionActualizarnooficial(){
        $param = Yii::$app->request->post();
        $model = $this->findModel($param['id']);
        $model->actividadnooficial = $param['estado'];
        $model->save();
        return $param['estado'];
    }

    public function actionResumen($dj)
    {
        return $this->generarResumen($dj);
    }

    public function actionPrint($dj, $mail = 0)
    {   
        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA]))
            $this->layout = 'main';
        else
            $this->layout = 'mainpersonal';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salida = '';
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $declaracionjurada = Declaracionjurada::findOne($dj);

        $agente = Agente::find()->where(['documento' => $declaracionjurada->agente])->one();
        
        $salida = $this->generarResumen($dj, 1);
        $filenamesext = "Declaración Jurada - ".$agente->apellido.', '.$agente->nombre;
        $filename =$filenamesext.".pdf";
        
        $content = $this->renderAjax('print', [
                'salida' => $salida,
                
               
            ]);

        //return $content;

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_FOLIO, 
        'marginTop' => 30,
        'defaultFontSize' => '8pt',
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $filename, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '

        
            .page-break{display: block;page-break-before: always;max-height: 100%;
                overflow: hidden;}
                
                td {
                    padding-top: 8px;
                    padding-bottom: 8px;
                }
                .label-default{
                    background-color:#FFFFFF;
                    border:0px;
                    color:#000000;
                }

                .kv-align-center{
                    text-align:center;
                }
                .well-lg{
                    background-color:#FFFFFF;
                    border:0px;
                    text-align:left;
                    font-size:9px;
                }
                .pull-right {
                    display: none;
                }
                .pull-left {
                    float: left!important;
                }

                img{
                    width: 200px;
                    margin-bottom:5px;
                }

                .leyenda-center{ 
                    text-align:center;
                }

                h1{
                    margin-top: 0px;
                    font-size:x-large;
                }

                
                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['<span><img src="assets/images/unc1_a.jpg" />||</span><span><img src="assets/images/logo-encabezado.png" /></span>'], 
            'SetFooter'=>[date('d/m/Y')." - ".$filenamesext.'|Página {PAGENO}|'],
        ]
    ]);
    if($mail == 0)
        return $pdf->render();
    else{
        
        $path = $pdf->Output($content,Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf',\Mpdf\Output\Destination::FILE);
        //$sendemail=true;
        $sendemail=Yii::$app->mailer->compose()
                        ->attach(Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf')
                        ->setFrom([Globales::MAIL => 'Sistemas Monserrat'])
                        ->setTo($agente->mail)
                        ->setSubject('Declaración jurada')
                        ->setHtmlBody('Se ha cargado correctamente su declaración jurada. Guarde este mail como constancia. Por favor no responda este correo ya que el mismo no será receptado por ningún destinatario, si tiene una consulta deberá comunicarse con la Oficina de Personal. Muchas gracias.')
                        ->send();
        if($sendemail)
        {
            //unlink(Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf');
            Yii::$app->session->setFlash('success', "Se ha completado y enviado correctamente la Declaración Jurada. Se deja constancia de su presentación en su casilla de correo.");
            return $this->redirect(['index']);
        }

    }
    
    }

    public function generarResumen($dj, $pr = 0)
    {
        
                
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA])){
            $this->layout = 'main';
            $declaracionjurada = Declaracionjurada::find()->where(['id' => $dj])->one();
            $agente = Agente::find()->where(['documento' => $declaracionjurada->agente])->one();
            
        }else{
            $this->layout = 'mainpersonal';
            $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            if($agente == null){
               
                    Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                    return $this->redirect(['index']); 
                
            }
            $declaracionjurada = Declaracionjurada::find()->where(['agente' => $agente->documento])->andWhere(['id' => $dj])->one();
        }
        /*if($pr == 1)
            $this->layout = 'mainpersonal';*/
        

        if($declaracionjurada == null){
            Yii::$app->session->setFlash('danger', "No tiene acceso a la Declaración Jurada");
            return $this->redirect(['index']);
        }
        
        if (Yii::$app->request->post()) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $declaracionjurada->fecha = date('Y-m-d');
            $declaracionjurada->estadodeclaracion = 2;
            $declaracionjurada->save();

            return $this->redirect(['print', 'dj' => $declaracionjurada->id, 'mail' => 1]);
            
        }
        
        $funciones = Funciondj::find()
        ->where(['declaracionjurada' => $declaracionjurada->id])
        ->andWhere(['is not','cargo',null])
        ->all();

        
        
        $actividadnooficial = Actividadnooficial::find()->where(['declaracionjurada' => $declaracionjurada->id])->one();
        $pasividaddj = Pasividaddj::find()->where(['declaracionjurada' => $declaracionjurada->id])->one();

        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        $columnas = [0,1,2,3,4,5,6,7];
        foreach ($funciones as $funcion) {
            $ch = 0;
            foreach ($columnas as $dia) {
                # code...
                
                    $array[$cd][0] = $cd+4; 
                
                    $array[$cd][1] = $funcion->reparticion;
                    $array[$cd][2] = $funcion->cargo;
                    $array[$cd][3] = $funcion->horas;
                    if($funcion->publico == 1){
                        $array[$cd][5] = 'Pública';
                    }else{
                        $array[$cd][5] = 'Privada';
                    }
                    
                    $array[$cd][6] = $funcion->dependencia;
                    if($funcion->licencia == 1){
                        $array[$cd][7] = 'No';
                    }else{
                        $array[$cd][7] = 'Sí';
                    }
                
                $ch = $ch + 1;
            }
            $cd = $cd + 1;
        }
        
        for ($i=$cd; $i < 5 ; $i++) { 
            $array[$i][0] = $i+4; 
            $array[$i][1] = '-';
            $array[$i][2] = '-';
            $array[$i][3] = '-';
            $array[$i][4] = '-';
            $array[$i][5] = '-';
            $array[$i][6] = '-';
            $array[$i][7] = '-';
        }

        
        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);


        $horarios = Horariodj::find()
            ->joinWith(['funciondj0', 'funciondj0.declaracionjurada0'])
            //->where(['diasemana' => 2])
            ->andWhere(['funciondj.declaracionjurada' => $declaracionjurada->id])
            ->andWhere(['is', 'horariodj.actividadnooficial', null])
            ->orderBy('diasemana, inicio')
            ->all();
        //return var_dump($horarios);

        $dias = Diasemana::find()->all();
        

        $cd2 = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        foreach ($dias as $dia) {
            $ch2 = 0;
            foreach ($funciones as $funcion) {
                # code...
                
                if($cd2 == 0){
                    $array[$funcion->id][-1] = $ch2+4;
                    if($funcion->licencia == 1)
                        $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.'</em>';
                    else
                        $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.' - Licencia</em>';
                }
                    
                if ($funcion->licencia == 1){
                    $array[$funcion->id][$dia->id] = '-';
                }else
                    $array[$funcion->id][$dia->id] = "- ";
                
                $ch2 = $ch2 + 1;
            }
            $cd2 = $cd + 1;
        }

        

        $salida = '';
        foreach ($horarios as $horariox) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            if($array[$horariox->funciondj][$horariox->diasemana] == '-'){
                $array[$horariox->funciondj][$horariox->diasemana] = '<div class="label label-default">'.Yii::$app->formatter->asDate($horariox->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariox->fin, 'HH:mm').' '.
                '</div><br />';
            }elseif($array[$horariox->funciondj][$horariox->diasemana] == '- '){
                $array[$horariox->funciondj][$horariox->diasemana] = '-';
            }else{
                $array[$horariox->funciondj][$horariox->diasemana] .= '<div class="label label-default">'.Yii::$app->formatter->asDate($horariox->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariox->fin, 'HH:mm').' '.
            '</div><br />';
            }
           
        }
        
        //$ch2 = count($funciones);


        for ($i=$ch2; $i < 5 ; $i++) { 
            $array[-$i*500][-1] = $i+4; 
            $array[-$i*500][0] = '-';
            $array[-$i*500][1] = '-';
            $array[-$i*500][2] = '-';
            $array[-$i*500][3] = '-';
            $array[-$i*500][4] = '-';
            $array[-$i*500][5] = '-';
            $array[-$i*500][6] = '-';
            $array[-$i*500][7] = '-';
        }

        //return var_dump($array);
        
        $provider2 = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);
        
        if($pr == 1){
            return $this->renderAjax('resumen', [
                'agente' => $agente,
                'declaracionjurada' => $declaracionjurada,
                'provider' => $provider,
                'provider2' => $provider2,
                'actividadnooficial' => $actividadnooficial,
                'pasividaddj' => $pasividaddj,
            ]);
        }else{
            return $this->render('resumen', [
                'agente' => $agente,
                'declaracionjurada' => $declaracionjurada,
                'provider' => $provider,
                'provider2' => $provider2,
                'actividadnooficial' => $actividadnooficial,
                'pasividaddj' => $pasividaddj,
            ]);
        }
            
    }
    
    /**
     * Updates an existing Declaracionjurada model.
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
     * Deletes an existing Declaracionjurada model.
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

    public function actionDeclaracionesjuradasadmin(){
        $this->layout = 'main';
        
        $anio = isset(Yii::$app->request->get()['Declaracionjurada']['fecha']) ? Yii::$app->request->get()['Declaracionjurada']['fecha'] : null;
        $pers = isset(Yii::$app->request->get()['Declaracionjurada']['agente']) ? Yii::$app->request->get()['Declaracionjurada']['agente'] : null;
        
        $ciclolectivo = Aniolectivo::find()->all();
        $agente = Agente::find()->all();
        

        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
        }else{
            $params = null;
        }
        
        $searchModel = new DeclaracionjuradaSearch();
        
        $dataProvider2 = $searchModel->porAnio(null);

        
        $models2 = $dataProvider2->getModels();

        if($pers != null || $anio != null){
            $dataProvider = $searchModel->porAnio($pers);
            $models = $dataProvider->getModels();
            $array = [];
            foreach ( $models as $key => $value) {
               
                    $array[$key]['documento'] = $value['documento'];
                    $array[$key]['apellido'] = $value['apellido'];
                    $array[$key]['nombre'] = $value['nombre'];
                    $array[$key]['mail'] = $value['mail'];
                
                
                if($anio == null){
                    
                        $djs = Declaracionjurada::find()->where(['agente' => $value['documento']])->all();
                }else{
                    $cl = Aniolectivo::findOne($anio);
                   
                    
                        $djs = Declaracionjurada::find()
                                    ->where(['agente' => $value['documento']])
                                    ->andWhere(['=', 'year(fecha)', $cl->nombre])
                                    ->all();
                    
                                    
                }
                
                if($djs != null){
                    
                    $max = 0;
                    foreach ($djs as $key2 => $dj) {
                        if($max<$dj->id){
                            //$array[$key]['dj'][$key2] = $dj->id;
                            $max = $dj->id;
                        }
                    }
                    foreach ($djs as $key3 => $dj3) {
                        if($max==$dj3->id){
                            
                            $array[$key]['dj'][$key2] = $dj3->id;
                            
                            //$max = $dj->id;
                        }
                    }
                    
                }
                
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => $array,
                'pagination' => false,
            ]);
        }else{
            $dataProvider = new ArrayDataProvider([
                'allModels' => [],
                'pagination' => false,
            ]);
        }
        

        $model = new Declaracionjurada();
        $param = Yii::$app->request->queryParams;
        if(isset($param['Declaracionjurada']['agente']))
            $model->agente = $param['Declaracionjurada']['agente'];
        if(isset($param['Declaracionjurada']['fecha']))
            $model->fecha = $param['Declaracionjurada']['fecha'];
        if(isset($param['Declaracionjurada']['estadodeclaracion']))
            $model->estadodeclaracion = $param['Declaracionjurada']['estadodeclaracion'];
        //return var_dump($array);
        return $this->render('declaracionesjuradasadmin', [
            //'searchModel' => $searchModel,
            'model' => $model,
            'models2' => $models2,
            'provider' => $dataProvider,
            'ciclolectivo' => $ciclolectivo,
            
            //'agente' => $array,
        ]);
    }

    public function actionCambiarestado(){
        $param = Yii::$app->request->post();
        //return var_dump($param['dj']);
        $model = $this->findModel($param['dj']);
        $model->estadodeclaracion = $param['es'];
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Declaracionjurada model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Declaracionjurada the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Declaracionjurada::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
