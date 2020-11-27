<?php

namespace app\modules\mones\controllers;

use app\config\Globales;
use Yii;
use app\modules\mones\models\Monacademica;
use app\modules\mones\models\MonacademicaSearch;
use app\modules\mones\models\Monalumno;
use app\modules\mones\models\Moncarrera;
use app\modules\mones\models\Monmatricula;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MonacademicaController implements the CRUD actions for Monacademica model.
 */
class MonacademicaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'printhistorial', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'printhistorial'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]) || in_array (Yii::$app->user->identity->username, Globales::mones);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Monacademica models.
     * @return mixed
     */

    public function actionIndex($doc,$car){
        $this->layout = '@app/views/layouts/mainpersonal';
        return $this->generarHistorial($doc,$car,0);
    }

    private function generarHistorial($doc,$car, $pr)
    {
        $searchModel = new MonacademicaSearch();
        $dataProvider = $searchModel->xalumnoymateria($doc,$car);
        $alumno = Monalumno::findOne($doc);
        $carrera = Moncarrera::findOne($car);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'alumno' => $alumno,
            'carrera' => $carrera,
            'pr' => $pr,
        ]);
    }

    /**
     * Displays a single Monacademica model.
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
     * Creates a new Monacademica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monacademica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Monacademica model.
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
     * Deletes an existing Monacademica model.
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
     * Finds the Monacademica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Monacademica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monacademica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrinthistorial($doc,$car){
        //$this->layout = null;
        $this->layout = 'vacio';
        
        $alumno = Monalumno::findOne($doc);
        $carrera = Moncarrera::findOne($car);
        $matricula = Monmatricula::find()->where(['alumno' => $doc])->andWhere(['carrera' => $car])->one();
        $al = $alumno->apellido.', '.$alumno->nombre;
        $fechanac = Yii::$app->formatter->asDate($alumno->fechanac, 'dd/MM/yyyy');
        $filenamesext = $alumno->documento.'-'.$al;
        $filename =$filenamesext.".pdf";

        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salida = '';
        
        $salida .= $this->generarHistorial($doc,$car,1);
        $content = $this->renderAjax('print', [
                'salida' => $salida,
                
               
            ]);

        //return $content;

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        'marginHeader' => 5,
        'marginLeft' => 5,
        'marginTop' => -62,
        'marginRight' => 5,
        'marginBottom' => 25,

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
                

                .panel-title{
                    text-align: center;
                    display: none;
                }
                .kv-grid-table{
                    font-size:10px;
                }
                .monacademica-index{
                   
                    max-height: 100%;
                    overflow: hidden;
                   
                }

                .pull-right {
                    display: none;
                }

                .container-fluid{
                    text-align: left;
                    font-weight: normal;
                    font-style: normal;
                }

                .bold{
                    font-weight: bold;
                }

                #imagen{
                    width: 300px;
                    height: 93px;
                }
                .cerradax{
                    float: left;
                }
                

                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat', 'setAutoTopMargin' => 'pad'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,

            'SetHeader'=>['<div class="container-fluid"><div class="row">
                                    <div class="col-xs-3">
                                        <img id="imagen" src="assets/images/enc3.png" />
                                    </div>
                                    <div class="col-xs-3">
                                        <ul style="padding-left: 0px;list-style:none;">
                                            <li><span class="bold">Estudiante:</span> '.$al.'</li>
                                            <li><span class="bold">Carrera:</span> '.$carrera->nombre.'</li>
                                            
                                            
                                        </ul>
                                    </div>
                                    <div class="col-xs-3">
                                        <ul style="padding-left: 0px;list-style:none;">
                                            <li><span class="bold">Documento:</span> '.$alumno->documento.'</li>
                                            <li><span class="bold">Fecha nac.:</span> '.$fechanac.'</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-1">
                                        <ul style="padding-left: 0px;list-style:none;">
                                                <li><span class="bold">CERT:</span> '.Yii::$app->formatter->asDate($matricula->certificado, 'dd/MM/yyyy').'</li>
                                                <li><span class="bold">LIBRO:</span> '.$matricula->libro.'</li>
                                                <li><span class="bold">FOLIO:</span> '.$matricula->folio.'</li>
                                            </ul> 
                                        
                                    </div>
                                </div><div class="row" style="text-align: center;"><span class="bold">Historial Académico - Mones 2.0</span></div></div>'], 
            'SetFooter'=>['<div class="container-fluid">
                            <div class="col-xs-3">
                            <span class="cerradax">Historial generado por: '.Yii::$app->user->identity->username.'</span>'
                            .'</div><div class="col-xs-3">.</div><div class="col-xs-6">'
                            .date('d/m/Y').' - Hoja {PAGENO}/{nb}'
                            .'</div>El presente documento no reemplaza bajo ningún punto de vista las actas originales en papel ni certifica que los datos concuerden con las mismas</div>'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }
}
