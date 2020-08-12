<?php

namespace app\controllers;

use app\config\Globales;
use app\models\DetallefonidSearch;
use app\models\Docente;
use Yii;
use app\models\Fonid;
use app\models\FonidSearch;
use app\modules\curriculares\models\Aniolectivo;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FonidController implements the CRUD actions for Fonid model.
 */
class FonidController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'detalleagente', 'view', 'create', 'cargos', 'resumen', 'print', 'update', 'delete', 'fonidadmin'],
                'rules' => [
                    [
                        'actions' => ['delete', 'view', 'resumen'],   
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
                        'actions' => ['index', 'update', 'create', 'print', 'cargos'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_PRECEPTOR]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['fonidadmin', 'detalleagente', 'print'],   
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
     * Lists all Fonid models.
     * @return mixed
     */

     
    public function actionIndex()
    {
        $this->layout = 'mainpersonal';
        $searchModel = new FonidSearch();
        $dataProvider = $searchModel->poragente(Yii::$app->request->queryParams);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $doc = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $fonidfecha = Fonid::find()->where(['docente' => $doc->id])->andWhere(['fecha' => date('Y-m-d')])->count();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fonidfecha' => $fonidfecha,
        ]);
    }

    /**
     * Displays a single Fonid model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'mainpersonal';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fonid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $persona = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $this->layout = 'mainpersonal';

        $cantidadabiertos = Fonid::find()
                                ->where(['docente' => $persona->id])
                                ->andWhere(['=', 'estadofonid', 1])
                                ->count();
                
        if($cantidadabiertos > 0){
            Yii::$app->session->setFlash('danger', 'No puede cargar un nuevo FONID ya que existe un formulario en estado de <b>Pendiente de Envío</b>. Puede ingresar al mismo para modificarlo y enviarlo.');
            return $this->redirect(['index']);
        }

        $model = new Fonid();
        $model->fecha = date('Y-m-d');
        $model->docente = $persona->id;
        $model->estadofonid = 1;
        $model->save();
        
        return $this->redirect(['update', 'id' => $model->id]);

       

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            
        ]);
    }

    /**
     * Updates an existing Fonid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'mainpersonal';
        $model = $this->findModel($id);

        $searchModel = new DetallefonidSearch();
        $dataProvider = $searchModel->search($model->id);

        $docente = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        if($model->docente != $docente->id){
            Yii::$app->session->setFlash('danger', 'No tiene autorización para realizar esta acción');
            return $this->redirect(['index']); 
        }

        $docente->scenario = Docente::SCENARIO_FONID;

        if (Yii::$app->request->post()) {
            
            $req = Yii::$app->request->post();
            
            if($req['btn_submit']=='ok'){
                $docente->apellido = $req['Docente']['apellido'];
                $docente->nombre = $req['Docente']['nombre'];
                $docente->cuil = $req['Docente']['cuil'];
                $docente->legajo = $req['Docente']['legajo'];
                $docente->save();
                //return var_dump($req);
            }
            
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->estadofonid = 2;
            $model->fecha = date('Y-m-d');
            $model->save();
            
            return $this->redirect(['print', 'fn' => $model->id, 'mail' => 1]);
        }
        

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'docente' => $docente,
            'fonid' => $model->id,
        ]);
    }

    public function actionSavedoc(){
        $docente = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        //$docente->scenario = Docente::SCENARIO_FONID;
        //$req = Yii::$app->request->post();
        $req = $_POST['cuil']; 
        //return $req;
        $docente->cuil = $req;
        
        $docente->save();
    }

    /**
     * Deletes an existing Fonid model.
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

    public function actionPrint($fn, $mail = 0)
    {
        $this->layout = 'mainpersonal';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }

        
        $salida = '';
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fonid = Fonid::findOne($fn);


        if($fonid->estadofonid != 2){
            Yii::$app->session->setFlash('danger', 'No tiene puede imprimir un formulario en estado <Pendiente>');
            return $this->redirect(['index']); 
        }
        $persona = Docente::find()->where(['id' => $fonid->docente])->one();

        $docente = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        if(in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_PRECEPTOR])){
            if($persona->id != $docente->id){
                Yii::$app->session->setFlash('danger', 'No tiene autorización para realizar esta acción');
                return $this->redirect(['index']); 
            }
        }
        
              
        
        $salida = $this->generarResumen($fn, 0);
        $filenamesext = "FONID - ".$persona->apellido.', '.$persona->nombre;
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
        'marginTop' => 40,
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

                th{
                    text-align:center;
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
                    margin-top: 40px; 
                    text-align:center;
                }
                .encab{
                    margin-bottom: 50px;
                }
                h2{
                    margin-top: 20px;
                    text-align: center;
                    font-size:x-large;
                    font-weight: bold;
                    
                }
                h1{
                    font-size:24px;
                    font-weight: bold;
                    text-align: center;
                    
                }
                tr{
                    
                    text-align: center;
                    
                }

                
                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['<span><img src="assets/images/min_ciencia_tecnologia_innovacion.png" />||</span><span><img src="assets/images/logo-encabezado.png" /></span>'], 
            'SetFooter'=>['|Página {PAGENO}|'],
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
                        ->setTo($persona->mail)
                        ->setSubject('FONID')
                        ->setHtmlBody('Se ha cargado correctamente su FONID. Guarde este mail como constancia.')
                        ->send();
        if($sendemail)
        {
            //unlink(Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf');
            Yii::$app->session->setFlash('success', "Se ha completado y enviado correctamente el FONID. Se deja constancia de su presentación en su casilla de correo. Por favor no responda este correo ya que el mismo no será receptado por ningún destinatario, si tiene una consulta deberá comunicarse con la Oficina de Personal. Muchas gracias.");
            return $this->redirect(['index']);
        }

    }
    
    }

    public function actionResumen($fn){
        return $this->generarResumen($fn, 1);
    }

    public function generarResumen($fn, $pr = 0)
    {

        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA])){
            $this->layout = 'main';
            $fonid = Fonid::find()->where(['id' => $fn])->one();
            $persona = Docente::find()->where(['id' => $fonid->docente])->one();
            
        }else{
            $this->layout = 'mainpersonal';
            $persona = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $fonid = Fonid::find()->where(['docente' => $persona->id])->andWhere(['id' => $fn])->one();
        }
        if($pr == 1)
            $this->layout = 'mainpersonal';

        $searchModel = new DetallefonidSearch();
        $dataProvider = $searchModel->search($fonid->id);
        

        return $this->renderAjax('resumen', [
            'persona' => $persona,
            'model' => $fonid,
            'dataProvider' => $dataProvider,
            
        ]);

    }

    public function actionFonidadmin(){
        $this->layout = 'main';
        
        $desde = isset(Yii::$app->request->get()['Fonid']['fecha']) ? substr(Yii::$app->request->get()['Fonid']['fecha'],0,10) : null;
        $hasta = isset(Yii::$app->request->get()['Fonid']['hasta']) ? Yii::$app->request->get()['Fonid']['hasta'] : null;
        $pers = isset(Yii::$app->request->get()['Fonid']['docente']) ? Yii::$app->request->get()['Fonid']['docente'] : null;
        
        

        $ciclolectivo = Aniolectivo::find()->all();
        $persona = Docente::find()->all();
        

        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
        }else{
            $params = null;
        }
        
        $searchModel = new FonidSearch();
        
        $dataProvider2 = $searchModel->porAnio(null);

        
        $models2 = $dataProvider2->getModels();

        if($pers != null || $desde != null){
            $dataProvider = $searchModel->porAnio($pers);
            $models = $dataProvider->getModels();
            $array = [];
            foreach ( $models as $key => $value) {
               
                    $array[$key]['id'] = $value['id'];
                    $array[$key]['documento'] = $value['documento'];
                    $array[$key]['apellido'] = $value['apellido'];
                    $array[$key]['nombre'] = $value['nombre'];
                    $array[$key]['mail'] = $value['mail'];
                
                
                if($desde == null){
                    
                        $djs = Fonid::find()->where(['docente' => $value['id']])->all();
                }else{
                    //$cl = Aniolectivo::findOne($anio);
                        
                        $desdeexplode = explode("/",$desde);
                        
                        $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
                        
                        $hastaexplode = explode("/",$hasta);
                        $newdatehasta = date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $hastaexplode[2]));
                        

                        $djs = Fonid::find()
                                    ->where(['docente' => $value['id']])
                                    ->andWhere(['and', 
                                        ['>=', 'fecha', $newdatedesde],
                                        ['<=', 'fecha', $newdatehasta],
                                    
                                    ])
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
        

        $model = new Fonid();
        $param = Yii::$app->request->queryParams;
        if(isset($param['Fonid']['docente']))
            $model->docente = $param['Fonid']['docente'];
        if(isset($param['Fonid']['fecha']))
            $model->fecha = $param['Fonid']['fecha'];
        if(isset($param['Fonid']['hasta']))
            $model->hasta = $param['Fonid']['hasta'];
        if(isset($param['Fonid']['estadofonid']))
            $model->estadofonid = $param['Fonid']['estadofonid'];
        //return var_dump($array);
        return $this->render('fonidadmin', [
            //'searchModel' => $searchModel,
            'model' => $model,
            'models2' => $models2,
            'provider' => $dataProvider,
            'ciclolectivo' => $ciclolectivo,
            
            //'persona' => $array,
        ]);
    }

    public function actionDetalleagente($d)
    {
        $this->layout = 'main';
        $searchModel = new FonidSearch();
        $dataProvider = $searchModel->porAgenteadmin($d);

        return $this->render('detalleagente', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Fonid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fonid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fonid::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
