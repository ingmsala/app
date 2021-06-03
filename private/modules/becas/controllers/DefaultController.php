<?php

namespace app\modules\becas\controllers;

use app\config\Globales;
use Yii;

use app\modules\becas\models\Becaalumno;
use app\modules\becas\models\Becaayudaestatal;
use app\modules\becas\models\Becaayudapersona;
use app\modules\becas\models\Becanivelestudio;
use app\modules\becas\models\Becaocupacion;
use app\modules\becas\models\Becaocupacionpersona;
use app\modules\becas\models\Becasolicitante;
use app\models\Parentesco;
use app\modules\becas\models\Becaconviviente;
use app\modules\becas\models\Becaconvocatoria;
use app\modules\becas\models\Becaestadoxsolicitud;
use app\modules\becas\models\Becanegativaanses;
use app\modules\becas\models\Becapersona;
use app\modules\becas\models\Becasolicitud;
use app\modules\curriculares\models\Alumno;
use kartik\helpers\Html;
use kartik\mpdf\Pdf;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * AdjuntoticketController implements the CRUD actions for Adjuntoticket model.
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'finalizaryenviar' => ['POST'],
                ],
            ],
        ];
    }

    public function actionError(){
        $this->layout = 'mainactivar';
        return $this->render('error', [
            
        ]);
    }
    
    public function actionIndex()
    {
        $this->layout = 'mainactivar';

        $convocatoria = 1;

        $conv = Becaconvocatoria::findOne($convocatoria);
        if($conv->becaconvocatoriaestado == 2){
            Yii::$app->session->setFlash('danger', "No se encuentra habilitada ninguna convocatoria a becas");
            return $this->redirect(['error']);
        }

        $modelalumno = new Becaalumno();
        $modelalumno->nivelestudio = 4;
        $modelsolicitante = new Becasolicitante();
        $ocupaciones = Becaocupacion::find()->all();
        $nivelestudio = Becanivelestudio::find()->all();
        $ayudasestatal = Becaayudaestatal::find()->all();
        $parentescos = Parentesco::find()
                        ->where(['in', 'id', [1,2,9,10]])
                        ->all();

        $modelocupacionesx = new Becaocupacionpersona();
        $modelayudax = new Becaayudapersona();

        if ($modelalumno->load(Yii::$app->request->post()) && $modelsolicitante->load(Yii::$app->request->post())) {

            
            $esalumno = $this->getEsalumno($modelalumno->cuil);
            if(!$esalumno){
                Yii::$app->session->setFlash('danger', "El CUIL no pertenece a ningún estudiante de la Institución.");
                return $this->redirect(['index']);
            }
            $repetido = $this->getRepetido($convocatoria, $modelalumno->cuil);
            if($repetido[0]){
                Yii::$app->session->setFlash('danger', "Ya existe una solicitud de beca asociada al CUIL del estudiante. Se envió un correo a la cuenta <b>{$repetido[1]}</b> con la que fue iniciada la solicitud.<br/>Si desea modificar los datos consignados, siga las instrucciones del correo electrónico.");
                return $this->redirect(['index']);
            }
            date_default_timezone_set('America/Argentina/Buenos_Aires');

            $images = UploadedFile::getInstances($modelalumno, 'image');
            $images2 = UploadedFile::getInstances($modelsolicitante, 'image');


            $nacalumno = explode("/",$modelalumno->fechanac);
            $newdatealumno = date("Y-m-d", mktime(0, 0, 0, $nacalumno[1], $nacalumno[0], $nacalumno[2]));
            $modelalumno->fechanac = $newdatealumno;

            $nacsolicitante = explode("/",$modelsolicitante->fechanac);
            $newdatesolicitante = date("Y-m-d", mktime(0, 0, 0, $nacsolicitante[1], $nacsolicitante[0], $nacsolicitante[2]));
            $modelsolicitante->fechanac = $newdatesolicitante;

            $alumnopersona = new Becapersona();
            $solicitantepersona = new Becapersona();
            $alumnopersona->save();
            $solicitantepersona->save();

            

            $modelalumno->persona = $alumnopersona->id;
            $modelsolicitante->persona = $solicitantepersona->id;

            $modelalumno->save();
            $modelsolicitante->save();

            

            $solicitud = new Becasolicitud();
            $solicitud->fecha = date('Y-m-d');
            $solicitud->solicitante = $modelsolicitante->id;
            $solicitud->estudiante = $modelalumno->id;
            $solicitud->convocatoria = $convocatoria;
            $solicitud->estado = 1;
            $solicitud->token = Yii::$app->security->generateRandomString(24);
            $solicitud->save();

            
            $solicitudestado = new Becaestadoxsolicitud();
            $solicitudestado->solicitud = $solicitud->id;
            $solicitudestado->estado = 1;
            $solicitudestado->fecha = date('Y-m-d H:i:s');
            $solicitudestado->solicitud = $solicitud->id;
            $solicitudestado->save();

            foreach ($modelalumno->ocupaciones as $ocupacionx) {
                $ocuX = new Becaocupacionpersona();
                $ocuX->persona = $modelalumno->persona;
                $ocuX->ocupacion = $ocupacionx;
                $ocuX->save();
            }

            foreach ($modelsolicitante->ocupaciones as $ocupacionxx) {
                $ocuX2 = new Becaocupacionpersona();
                $ocuX2->persona = $modelsolicitante->persona;
                $ocuX2->ocupacion = $ocupacionxx;
                $ocuX2->save();
            }

            foreach ($modelalumno->ayudas as $ayudax) {
                $ayuX = new Becaayudapersona();
                $ayuX->persona = $modelalumno->persona;
                $ayuX->ayuda = $ayudax;
                $ayuX->save();
            }

            foreach ($modelsolicitante->ayudas as $ayudaxx) {
                $ayuX2 = new Becaayudapersona();
                $ayuX2->persona = $modelsolicitante->persona;
                $ayuX2->ayuda = $ayudaxx;
                $ayuX2->save();
            }



            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosAL = new Becanegativaanses();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosAL->nombre = $image->name;
                    $modelajuntosAL->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosAL->persona = $modelalumno->persona;
                    $modelajuntosAL->solicitud = $solicitud->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/negativaansesFMfcgzGkXSTfLSXK/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosAL->url;
                    $image->saveAs($path);
                    $modelajuntosAL->save();
                    $modelalumno->negativaanses = $modelajuntosAL->id;
                    $modelalumno->save();
                    
                }
                
            }

            if (!is_null($images2)) {
                foreach ($images2 as $image2) {
                    $modelajuntosSOL = new Becanegativaanses();
                    $arr = [];
                    $arr = explode(".", $image2->name);
                    $ext = end($arr);
                    $modelajuntosSOL->nombre = $image2->name;
                    $modelajuntosSOL->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosSOL->persona = $modelsolicitante->persona;
                    $modelajuntosSOL->solicitud = $solicitud->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/negativaansesFMfcgzGkXSTfLSXK/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosSOL->url;
                    $image2->saveAs($path);
                    $modelajuntosSOL->save();
                    $modelsolicitante->negativaanses = $modelajuntosSOL->id;
                    $modelsolicitante->save();
                }
                
            }

            if($modelsolicitante->conviviente == 1){
                $conviviente = new Becaconviviente();
                $conviviente->apellido = $modelsolicitante->apellido;
                $conviviente->nombre = $modelsolicitante->nombre;
                $conviviente->cuil = $modelsolicitante->cuil;
                $conviviente->fechanac = $modelsolicitante->fechanac;
                $conviviente->nivelestudio = $modelsolicitante->nivelestudio;
                $conviviente->parentesco = $modelsolicitante->parentesco;
                $conviviente->solicitud = $solicitud->id;
                $conviviente->persona = $modelsolicitante->persona;
                $conviviente->ocupaciones = $modelsolicitante->ocupaciones;
                $conviviente->ayudas = $modelsolicitante->ayudas;
                $conviviente->negativaanses = $modelsolicitante->negativaanses;
                $conviviente->save();

            }


            $sendemail=Yii::$app->mailer->compose()
                        ->setFrom([Globales::MAIL => 'Sistema de Becas CNM'])
                        ->setTo($solicitud->solicitante0->mail)
                        ->setSubject('Se ha creado una nueva solicitud de beca')
                        ->setHtmlBody('
                            Se registró una solicitud de beca, puede modificarla ingresando a '.Html::a('http://admin.cnm.unc.edu.ar/front/index.php?r=becas%2Fdefault%2Fsolicitud&s='.$solicitud->token, Url::to(['/becas/default/solicitud', 's' => $solicitud->token], true)).'.
                         <br> Por favor no conteste este correo ya que se envió de manera automatica y la casilla no es revisada por personal de la Institución. Si tiene alguna duda o consulta puede realizarla a través de los canales oficiales del Colegio.')
                        ->send();
            
            return $this->redirect(['grupofamiliar', 's' => $solicitud->token]);
            
        }

        return $this->render('index', [
            'modelalumno' => $modelalumno,
            'ocupaciones' => $ocupaciones,
            'nivelestudio' => $nivelestudio,
            'ayudasestatal' => $ayudasestatal,
            'modelocupacionesx' => $modelocupacionesx,
            'modelayudax' => $modelayudax,

            'modelsolicitante' => $modelsolicitante,
            'parentescos' => $parentescos,
        ]);
        
    }

    private function getRepetido($convocatoria, $cuil){

        $ret = [false, ''];
        $solicitudes = Becasolicitud::find()
                        ->joinWith(['estudiante0'])
                        ->where(['convocatoria' => $convocatoria])
                        ->andWhere(['becaalumno.cuil' => $cuil])
                        ->one();
        
        if($solicitudes !=null){
            $ret = [true, substr_replace($solicitudes->solicitante0->mail, '******', 5, 10)];
        }

        return $ret;

    }
    private function getEsalumno($cuil){

        $ret = false;

        try {
            $dniexp = explode('-', $cuil);
            $dni = $dniexp[1];
        } catch (\Throwable $th) {
            $dni = 0;
        }
        
        $alumno = Alumno::find()
                        ->where(['documento' => $dni])
                        ->one();
        
        if($alumno !=null){
            $ret = true;
        }

        return $ret;

    }

    public function actionGrupofamiliar($s)
    {
        $this->layout = 'mainactivar';
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();

        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }

        if($solicitud->estado != 1 && $solicitud->estado != 2){
            $edit = false;
        }else{
            $edit = true;
        }
        
        $echosalida = $this->getGrupofliar($solicitud, $edit);
        return $this->render('grupofamiliar', [
            'echosalida' => $echosalida,
            'edit' => $edit,
            'token' => $s,

            
        ]);


        /*$modelalumno = new Becaalumno();
        $modelalumno->nivelestudio = 4;
        $modelsolicitante = new Becasolicitante();
        $ocupaciones = Becaocupacion::find()->all();
        $nivelestudio = Becanivelestudio::find()->all();
        $ayudasestatal = Becaayudaestatal::find()->all();
        $parentescos = Parentesco::find()->all();

        $modelocupacionesx = new Becaocupacionpersona();
        $modelayudax = new Becaayudapersona();*/
    }

    private function getGrupofliar($solicitud, $edit){

        $echosalida = '';

        
        foreach ($solicitud->becaconvivientes as $model) {
            
            if($edit){
                $update = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to(['/becas/becaconviviente/update', 'id' => $model->id]), 'title' => 'Modificar conviviente', 'class' => 'amodalgenerico updatetbn novisible']);
                $delete = Html::a('×', ['/becas/becaconviviente/delete', 'id' => $model->id], [
                    'class' => 'close novisible',
                    'data' => [
                        'confirm' => 'Este proceso borra a la persona del grupo familar. Está seguro que desea proceder?',
                        'method' => 'post',
                    ],
                ]);
            }else{
                $update = '';
                $delete = '';
            }

            $viewconviviente = $this->renderAjax('/becaconviviente/view', ['model' => $model]);
            $echosalida .= '<div class="vista-listado flowGrid">
                    <div class="item-aviso flowGridItem">
                        <div class="header-aviso-resultados Empleos">
                            <h3>'.$model->apellido.', '.$model->nombre.'</h3>'.$update.$delete.'
                            <h4><span class="label label-default">'.$model->parentesco0->nombre.'</span></h4>
                            
                        </div>
                        <div class="content-aviso-resultados">
                        '.$viewconviviente.'
                        </div>
                        
                    </div>
                                    
                  </div>';
        
            $echosalida .= '<div class="clearfix"></div>';
        }

        return $echosalida;

    }

    public function actionSolicitud($s){
        $this->layout = 'mainactivar';
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();
        

        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }

        if($solicitud->estado != 1 && $solicitud->estado != 2){
            $edit = false;
        }else{
            $edit = true;
        }
        
        $echosalida = $this->getSolicitud($solicitud, $edit);
        

        return $this->render('solicitud', [
            'echosalida' => $echosalida,
            'edit' => $edit,
            'token' => $s,
            
        ]);

    }

    private function getSolicitud($solicitud, $edit){
        $echosalida = '';
        $personas = ['estudiante' => $solicitud->estudiante0, 'solicitante' => $solicitud->solicitante0];
        foreach ($personas as $tipo => $model) {
            # code...
        
            
                
                if($tipo == 'estudiante'){
                    $tipopersona = "Estudiante";
                    $classtipo = 'info';
                    $construct = 'becaalumno';
                }else{
                    $tipopersona = "Solicitante";
                    $classtipo = "warning";
                    $construct = 'becasolicitante';
                }

                if($edit){
                    $update = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to(['/becas/'.$construct.'/update', 'id' => $model->id, 's' => $solicitud->token]), 'title' => 'Modificar '.$tipopersona, 'class' => 'amodalgenerico updatetbn novisible']);
                    $delete = '';
                }else{
                    $update = '';
                    $delete = '';
                }

                $viewconviviente = $this->renderAjax('/'.$construct.'/view', ['model' => $model]);
                $echosalida .= '<div class="vista-listado flowGrid">
                        <div class="item-aviso flowGridItem">
                            <div class="header-aviso-resultados Empleos">
                                <h3>'.$model->apellido.', '.$model->nombre.'</h3>'.$update.$delete.'
                                <h4><span class="label label-'.$classtipo.'">'.$tipopersona.'</span></h4>
                                
                                
                            </div>
                            <div class="content-aviso-resultados">
                            '.$viewconviviente.'
                            </div>
                            
                        </div>
                                        
                    </div>';
            
                $echosalida .= '<div class="clearfix"></div>';
        }
        return $echosalida;
    }

    public function actionFinalizar($s){
        
        $this->layout = 'mainactivar';
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();

        

        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }

        $echosalida = $this->getResumen($solicitud);
        $echosalidasol = $echosalida[0];
        $echosalidaflia = $echosalida[1];
        

        return $this->render('finalizar', [
            'echosalidasol' => $echosalidasol,
            'echosalidaflia' => $echosalidaflia,
            'token' => $s,
            'solicitud' => $solicitud,

            
        ]);
    }

    private function getResumen($solicitud){

        $echosalidaflia = $this->getGrupofliar($solicitud, false);
        $echosalidasol = $this->getSolicitud($solicitud, false);
        return [$echosalidasol, $echosalidaflia];
    }

    public function actionFinalizaryenviar($s){
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();
        if($solicitud->convocatoria0->becaconvocatoriaestado == 2){
            Yii::$app->session->setFlash('danger', "No se encuentra habilitada ninguna convocatoria a becas");
            return $this->redirect(['/becas/default/error']);
        }
        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }
        $solicitud->estado = 2;
        $solicitud->save();

        $solicitudestado = new Becaestadoxsolicitud();
        $solicitudestado->solicitud = $solicitud->id;
        $solicitudestado->estado = 2;
        $solicitudestado->fecha = date('Y-m-d H:i:s');
        $solicitudestado->solicitud = $solicitud->id;
        $solicitudestado->save();

        $sendemail=Yii::$app->mailer->compose()
                        ->setFrom([Globales::MAIL => 'Sistema de Becas CNM'])
                        ->setTo($solicitud->solicitante0->mail)
                        ->setSubject('Se ha generado la solicitud de beca correctamente')
                        ->setHtmlBody('
                            Se ha registrado la solicitud de beca. Podrá ser modificada hasta la fecha '.Yii::$app->formatter->asDate($solicitud->convocatoria0->hasta, 'dd/MM').' ingresando a '.Html::a('http://admin.cnm.unc.edu.ar/front/index.php?r=becas%2Fdefault%2Fsolicitud&s='.$s, Url::to(['/becas/default/solicitud', 's' => $s], true)).'
                        <br> Luego de esa fecha no será posible realizar modificaciones. <br> <br> Por favor no conteste este correo ya que se envió de manera automatica y la casilla no es revisada por personal de la Institución. Si tiene alguna duda o consulta puede realizarla a través de los canales oficiales del Colegio.')
                        ->send();
        if($sendemail)
        {
            //unlink(Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf');
            Yii::$app->session->setFlash('success', "Se ha completado y enviado correctamente la solicitud de beca. Se enviará la constancia de la presentación en la casilla de correo del solicitante.");
            return $this->redirect(['index']);
        }



    }

    public function actionPrint($s){
        return $this->getPrint($s);
    }

    public function getPrint($s){
        
        $g = new Globales();
        $this->layout = $g->getLayout(0);
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();

        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }

        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }

        $salidaimpar = '';
        

        $echosalida = $this->getResumen($solicitud);
        $echosalidasol = $echosalida[0];
        $echosalidaflia = $echosalida[1];

        $filenamesext = "Solicitud de beca - {$solicitud->estudiante0->apellido}, {$solicitud->estudiante0->nombre}";
        $filename =$filenamesext.".pdf";

        $content = $this->renderAjax('finalizar', [
            'echosalidasol' => $echosalidasol,
            'echosalidaflia' => $echosalidaflia,
            'token' => $solicitud->token,
            'solicitud' => $solicitud,
            
           
        ]);

        
        
        $echosalidaflia = $this->getGrupofliar($solicitud, false);
        $echosalidasol = $this->getSolicitud($solicitud, false);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        //'defaultFontSize' => 6,
        'marginTop' => 25,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $filename, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@webroot/css/print.css',
        // any css to be embedded if required
        'cssInline' => '
                
                                

            .pull-right {
                display: none;
            }
            .novisible {
                display: none;
            }

                
            .salto{
                
                max-height: 100%;
                overflow: hidden;
                page-break-after: always;
            }
            

                

                

                ', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['||<span><img width="15%" src="assets/images/enc3.png" /></span>', ['style '=> ['background-color' => '#000']]], 
            'SetFooter'=>[date('d/m/Y')." - ".$filenamesext.'||{PAGENO}/{nbpg}'],
        ]
    ]);

    

    
    // return the pdf output as per the destination setting
    //return $salidaimpar;
    
    return $pdf->render();
    }

}
