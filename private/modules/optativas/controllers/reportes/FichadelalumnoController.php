<?php

namespace app\modules\optativas\controllers\reportes;

use Yii;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\Comision;
use app\modules\optativas\models\Clase;
use app\modules\optativas\models\Optativa;
use app\modules\optativas\models\InasistenciaSearch;
use app\modules\optativas\models\SeguimientoSearch;
use app\modules\optativas\models\Inasistencia;
use app\modules\optativas\models\Estadomatricula;
use app\modules\optativas\models\MatriculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use \Datetime;
use kartik\mpdf\Pdf;



/**
 * MatriculaController implements the CRUD actions for Matricula model.
 */
class FichadelalumnoController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'all','print'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'all', 'print'],   
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
     * Lists all Matricula models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
            $comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($comision != 0){
            $dataProvider = $searchModel->alumnosxcomision($comision);
               
            return $this->render('index', [
                
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'comision' => $comision,

            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }

    }

    /**
     * Displays a single Matricula model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $this->layout = 'main';
        $comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($comision != 0){
            $searchModelInasistencias  = new InasistenciaSearch();
            $dataProviderInasistencias = $searchModelInasistencias->providerinasistenciasxalumno($id);

            $clasescomision = Clase::find()
                                ->where(['comision' => $comision])
                                ->orderBy('fecha ASC')
                                ->all();

            $listClasescomision=ArrayHelper::map($clasescomision,
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model->fecha, 'dd/MM');
                        
                    },
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha = date_create($model->fecha);
                        $hoy = new DateTime("now");
                        $interval = $fecha->diff($hoy);
                        $signo = $interval->format('%R');
                        //$interval = $interval->format('%a');
                        //$interval = intval($interval);
                        //return $signo;
                        if ($signo == '+')
                            return "P";
                        else
                            return '';
                    }
            );

            $faltasdelalumno = Inasistencia::find()
                                ->joinWith(['clase0'])
                                ->where(['matricula' => $id])
                                ->andWhere(['clase.comision' => $comision])
                                ->all();


            $listFaltasdelalumno=ArrayHelper::map($faltasdelalumno,
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model->clase0->fecha, 'dd/MM');
                        
                    },
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha = date_create($model->clase0->fecha);
                        $hoy = new DateTime("now");
                        $interval = $fecha->diff($hoy);
                        $signo = $interval->format('%R');

                        if ($signo == '+')
                            return "A";
                        else
                            return '';
                    });

            $listClasescomision = array_merge($listClasescomision, $listFaltasdelalumno);
            
           /* $data = [
                $listClasescomision,
                
            ];
    
            $dataProviderInasistencias = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ],
                
            ]);*/
            $ids = ArrayHelper::getColumn($listClasescomision, 0);
            $echodiv='';
            $i=0;
            $ca = 0;
            foreach ($listClasescomision as $key => $value) {

                if($value == "P"){
                    $paneltype = 'success';
                    $prt = $value;
                }
                elseif ($value == "A"){
                    $paneltype = 'danger';
                    $prt = '<b>'.$value.'</b>';
                }
                else
                    break;
                if($value == "A"){
                    $ca ++;
                    $echodiv .= '<div class="col-md-2 col-lg-2 col-sm-2 col-lx-2">';
                    $echodiv .= '<div class="panel panel-'.$paneltype.'" style="height: 12vh; margin:2px">';
                    $echodiv .= '<div class="panel-heading" style="height: 5vh;">'.'<center>'.$key.'</center>'.'</div>';
                    $echodiv .= '<div class="panel-body"><span class="align-top">';
                    //$echodiv .= Html::checkbox("scripts", $sel, ['label' => 'Se Ausentó', 'value' => $matricula["id"]]);
                    $echodiv .= '<center>'.$prt.'</center>';
                    $echodiv .= '</span></div>
                                    </div>
                                  </div>';
                }
                
                $i=$i+1;
            }

            $porcentajeausencia = round($ca*100/($i+$ca));

            $searchModelSeguimientos  = new SeguimientoSearch();
            $dataProviderSeguimientos = $searchModelSeguimientos->seguimientosdelalumno($id);


            return $this->render('view', [
                'dataProviderInasistencias' => $dataProviderInasistencias,
                'listClasescomision' => $listClasescomision,
                'dataProviderSeguimientos' => $dataProviderSeguimientos,
                'porcentajeausencia' => $porcentajeausencia,
                'echodiv' => $echodiv,
                'model' => $this->findModel($id),
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }
    }



    public function actionAll($comision){
        //$this->layout = 'print';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salidaimpar = '';
        $salidapar = '';
        $impar = true;
        $searchModel = new MatriculaSearch();
        //$comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        $dataProvider = $searchModel->alumnosxcomision($comision);


        $com = Comision::find()
                                ->where(['id' => $comision])
                                ->one();
        $optativa = $com->optativa0->aniolectivo0->nombre.' - '.$com->optativa0->actividad0->nombre;
        //$salidaimpar =$comision;
        foreach ($dataProvider->getKeys() as $id) {
            if($impar){
                            $salidaimpar .= $this->generarFicha($id, $comision);
                            //$salidaimpar .= '<pagebreak/>';
            }else{
                $salidaimpar .= $this->generarFicha($id, $comision);
                //$salidapar .= '<pagebreak/>';
            }
              $impar = $impar;
        }
        $content = $this->renderAjax('all', [
                'salidaimpar' => $salidaimpar,
                'salidapar' => $salidapar,
               
            ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $optativa.'.pdf', 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
                h3 {
                  font-size: 22px;
                }
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                        float: left;
                    }

                .col-sm-2 {
                        width: 7%;

                        
                   } 
                .fichadelalumnotable{
                    margin-top: -70px;
                    max-height: 100%;
                    overflow: hidden;
                    page-break-after: always;
                }

                .pull-right {
                    display: none;
                }
                #firma{ 
                    
                    margin-top: 50px;
                    text-align: center;
                }

                #encabezado{ 
                    margin: auto;
                    
                    width: 200px;

                }', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Colegio Nacional de Monserrat'], 
            'SetFooter'=>['Espacios Optativos'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render(); 
    }

    protected function generarFicha($id, $comision)
    {
         $searchModelInasistencias  = new InasistenciaSearch();
            $dataProviderInasistencias = $searchModelInasistencias->providerinasistenciasxalumno($id);
            //$comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;

            $clasescomision = Clase::find()
                                ->where(['comision' => $comision])
                                ->orderBy('fecha ASC')
                                ->all();

            $listClasescomision=ArrayHelper::map($clasescomision,
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model->fecha, 'dd/MM');
                        
                    },
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha = date_create($model->fecha);
                        $hoy = new DateTime("now");
                        $interval = $fecha->diff($hoy);
                        $signo = $interval->format('%R');
                        //$interval = $interval->format('%a');
                        //$interval = intval($interval);
                        //return $signo;
                        if ($signo == '+')
                            return "P";
                        else
                            return '';
                    }
            );

            $faltasdelalumno = Inasistencia::find()
                                ->joinWith(['clase0'])
                                ->where(['matricula' => $id])
                                ->andWhere(['clase.comision' => $comision])
                                ->all();


            $listFaltasdelalumno=ArrayHelper::map($faltasdelalumno,
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model->clase0->fecha, 'dd/MM');
                        
                    },
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha = date_create($model->clase0->fecha);
                        $hoy = new DateTime("now");
                        $interval = $fecha->diff($hoy);
                        $signo = $interval->format('%R');

                        if ($signo == '+')
                            return "A";
                        else
                            return '';
                    });

            $listClasescomision = array_merge($listClasescomision, $listFaltasdelalumno);
            
           /* $data = [
                $listClasescomision,
                
            ];
    
            $dataProviderInasistencias = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ],
                
            ]);*/
            $ids = ArrayHelper::getColumn($listClasescomision, 0);
            $echodiv='';
            $i=0;
            $ca = 0;
            foreach ($listClasescomision as $key => $value) {

                if($value == "P"){
                    $paneltype = 'success';
                    $prt = $value;
                }
                elseif ($value == "A"){
                    $paneltype = 'danger';
                    $prt = '<b>'.$value.'</b>';
                }
                else
                    break;
                if($value == "A"){
                    $ca ++;
                    $echodiv .= '<div class="col-md-2 col-lg-2 col-sm-2 col-lx-2">';
                    $echodiv .= '<div class="panel panel-'.$paneltype.'" style="height: 12vh; margin:2px">';
                    $echodiv .= '<div class="panel-heading" style="height: 5vh;">'.'<center>'.$key.'</center>'.'</div>';
                    $echodiv .= '<div class="panel-body"><span class="align-top">';
                    //$echodiv .= Html::checkbox("scripts", $sel, ['label' => 'Se Ausentó', 'value' => $matricula["id"]]);
                    $echodiv .= '<center>'.$prt.'</center>';
                    $echodiv .= '</span></div>
                                    </div>
                                  </div>';
                }
                
                $i=$i+1;
            }

            $porcentajeausencia = round($ca*100/($i+$ca));

            $searchModelSeguimientos  = new SeguimientoSearch();
            $dataProviderSeguimientos = $searchModelSeguimientos->seguimientosdelalumno($id);

            return $this->renderAjax('view', [
                'dataProviderInasistencias' => $dataProviderInasistencias,
                'listClasescomision' => $listClasescomision,
                'dataProviderSeguimientos' => $dataProviderSeguimientos,
                'porcentajeausencia' => $porcentajeausencia,
                'echodiv' => $echodiv,
                'model' => $this->findModel($id),
            ]);
    }
 
    /**
     * Finds the Matricula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Matricula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Matricula::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionPrint($matricula){
        //$this->layout = 'print';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        
        $mat = Matricula::find()->where(['id' => $matricula])->one();
        

        $salidaimpar = $this->generarFicha($matricula, $mat->comision);
        //$salidaimpar =$comision;
        
        $content = $this->renderAjax('all', [
                'salidaimpar' => $salidaimpar,
                
               
            ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $mat->alumno0->apellido.'_'.$mat->alumno0->nombre.'.pdf', 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                        float: left;
                    }

                .col-sm-2 {
                        width: 7%;
                        
                   } 
                .fichadelalumnotable{
                    margin-top: -70px;
                    max-height: 100%;
                    overflow: hidden;
                    page-break-after: always;
                }

                .pull-right {
                    display: none;
                }
                #firma{ 
                    
                    margin-top: 50px;
                    text-align: center;
                }

                #encabezado{ 
                    margin: auto;
                    
                    width: 200px;

                }', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Colegio Nacional de Monserrat'], 
            'SetFooter'=>['Espacios Optativos'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render(); 
    }
    
}
