<?php

namespace app\modules\solicitudprevios\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\Division;
use app\models\Turnoexamen;
use app\modules\solicitudprevios\models\Adjuntosolicitudext;
use app\modules\solicitudprevios\models\Detallesolicitudext;
use app\modules\solicitudprevios\models\Estadoxsolicitudext;
use Yii;

use app\modules\solicitudprevios\models\Solicitudinscripext;
use kartik\mpdf\Pdf;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

class CrearController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'imprimir' => ['POST'],
                ],
            ],
        ];
    }



    public function actionIndex($t=1)
    {
        $this->layout = 'mainactivar';
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $model = new Solicitudinscripext();
        $model->fecha = date('d/m/Y');
        $modelDetalle = new Detallesolicitudext();
        $modelAjuntos = new Adjuntosolicitudext();
        try {
            if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_DESPACHO])){
                $turnoexamen = Turnoexamen::find()->where(['tipoturno' => $t])->andWhere(['<>', 'activo', 3])->all();
            }else{
                $turnoexamen = Turnoexamen::find()->where(['tipoturno' => $t])->andWhere(['activo' => 1])->all();
            }
        } catch (\Throwable $th) {
            $turnoexamen = Turnoexamen::find()->where(['tipoturno' => $t])->andWhere(['activo' => 1])->all();
        }

        $divisiones = Division::find()->where(['<=', 'preceptoria', 6])->all();
        

        if(count($turnoexamen)==0){
            Yii::$app->session->setFlash('danger', 'No está habilitado ningún turno de examen. Consulte el calendario académico para verificar las fechas de apertura de inscripcionres.');
        }
        if($t == 1)
            $habilitados = [6,7];
        else
            $habilitados = [1,2,3,4,5,6];
        $actividades = Actividad::find()
                            //->joinWith(['catedras', 'catedras.division0'])
                            ->where(['in', 'curso', $habilitados])
                            ->andWhere(['propuesta' => 1])
                            ->andWhere(['actividadtipo' => 1])
                            ->orderBy('nombre')->all();
        //$actividades = Actividad::find()->where(['propuesta' => 1])->andWhere(['actividadtipo' => 1])->orderBy('nombre')->all();

        if ($model->load(Yii::$app->request->post()) && $modelAjuntos->load(Yii::$app->request->post())) {

            
            ini_set("pcre.backtrack_limit", "5000000");
            ini_set( 'upload_max_size' , '256M' );
            ini_set( 'post_max_size', '256M');
            ini_set( 'max_execution_time', '300' );
            
            $images = UploadedFile::getInstances($modelAjuntos, 'image');
            //return var_dump($images);

            $actividadesSeleccionadas = Yii::$app->request->post()['Detallesolicitudext']['actividad'];
            $fechaexplode = explode("/",$model->fecha);
            $newdatefecha = date("Y-m-d", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[0], $fechaexplode[2]));
            $model->fecha = $newdatefecha;

            $model->save();
            //return var_dump($model->id);
            foreach ($actividadesSeleccionadas as $actividad) {
                $modelDetalleX = new Detallesolicitudext();
                $modelDetalleX->solicitud = $model->id;
                $modelDetalleX->actividad = $actividad;
                $modelDetalleX->save();
                $newEstado = new Estadoxsolicitudext();
                $newEstado->estado = 1;
                $newEstado->detalle = $modelDetalleX->id;
                $newEstado->fecha = date('Y-m-d');
                $newEstado->save();
                $modelDetalleX->estado = $newEstado->id;
                $modelDetalleX->save();

            }

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosX = new Adjuntosolicitudext();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosX->nombre = $image->name;
                    $modelajuntosX->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosX->solicitud = $model->id;
                    
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/solicitud6d639c31fbcc6029/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosX->url;

                    $image->saveAs($path);

                    $modelajuntosX->image = 's';
                    $modelajuntosX->save();

                   
                    
                }
                
            }


            $renderconstancia = $this->renderAjax('/solicitudinscripext/view', [
                'model' => $model,
            ]);

            Yii::$app->session->setFlash('success', 'Se registró correctamente su solicitud');

            return $this->render('/solicitudinscripext/comprobante', [
                'echodiv' => $renderconstancia,
            ]);
            return $this->doImprimir($model);

            return $this->redirect(['index']);
        }

        return $this->render('/solicitudinscripext/create', [
            'model' => $model,
            'modelDetalle' => $modelDetalle,
            'modelAjuntos' => $modelAjuntos,
            'turnoexamen' => $turnoexamen,
            'actividades' => $actividades,
            'divisiones' => $divisiones,
            't' => $t,
        ]);
    }

    public function actionImprimir($id)
    {
        
        
        $model = Solicitudinscripext::findOne($id);
        
        
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }

        $renderconstancia = $this->renderAjax('/solicitudinscripext/view', [
            'model' => $model,
        ]);
        
        
        $filenamesext = "comprobante";
        $filename =$filenamesext.".pdf";
        
        $content = $this->renderAjax('/solicitudinscripext/comprobante', [
            'echodiv' => $renderconstancia,
        ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        'marginTop' => 25,
        'defaultFontSize' => '7pt',
        // portrait orientation
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
                
                .body{
                    font-size = 7pt;
                }
                
                .horarioxcurso-view{
                    margin-top: -70px;
                    max-height: 100%;
                    overflow: hidden;
                    page-break-after: always;
                }

                .pull-right {
                    display: none;
                }
                .btn-default {
                    display: none;
                }

                img{
                    width: 200px;
                }

                
                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['<span><img src="assets/images/logo-encabezado.png" /></span>'], 
            'SetFooter'=>[date('d/m/Y')],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render();
       
        
    }

}
