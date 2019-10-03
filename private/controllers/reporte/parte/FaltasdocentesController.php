<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use app\models\DetalleparteSearch;
use app\models\Detalleparte;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;
use app\modules\optativas\models\Aniolectivo;
use kartik\mpdf\Pdf;

class FaltasdocentesController extends \yii\web\Controller
{


	/**
     * {@inheritdoc}
     */
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'all'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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

 	public function actionIndex($mes = 0, $anio = 1, $docente = 0)
	    {
	        $searchModel = new DetalleparteSearch();
	        $dataProvider = $searchModel->providerfaltasdocentes($mes, $anio, $docente);
            $model = new Detalleparte();
            $param = Yii::$app->request->queryParams;
            $years = Aniolectivo::find()->all();
            	        
	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'anio' => $anio,
                'mes' => $mes,
                'docente' => $docente,
                'model' => $model,
                'param' => $param,
                'docentes' => Docente::find()->orderBy('apellido, nombre')->all(),
                'years' => $years,
	        ]);
	    }

	public function actionView($mes = 0, $anio = 0, $id)
    {
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerfaltasdocentesview($mes, $anio, $id);
 
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'anio' => $anio,
            'mes' => $mes,
        ]);
    }

	protected function findModel($id)
    {
        if (($model = Docente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




public function actionAll($docente){
        //$this->layout = 'print';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }

        $doc = $this->findModel($docente);

        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerfaltasdocentesview(0, 2019, $docente);
 
        $salidaimpar = $this->renderAjax('view', [
            'model' => $this->findModel($docente),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'anio' => 2019,
            'mes' => 0,
        ]);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = Yii::$app->formatter->asDate(date("D M d"), 'dd/MM/yyyy');
        //$date = ;

        
        $content = $salidaimpar;

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $doc->apellido.'_'.$doc->nombre.'.pdf', 
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
            'SetFooter'=>['Generado por '.Yii::$app->user->identity->username.' el '.$date],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render(); 
    }

}