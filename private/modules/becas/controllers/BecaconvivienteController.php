<?php

namespace app\modules\becas\controllers;

use app\models\Parentesco;
use app\modules\becas\models\Becaayudaestatal;
use app\modules\becas\models\Becaayudapersona;
use Yii;
use app\modules\becas\models\Becaconviviente;
use app\modules\becas\models\BecaconvivienteSearch;
use app\modules\becas\models\Becanegativaanses;
use app\modules\becas\models\Becanivelestudio;
use app\modules\becas\models\Becaocupacion;
use app\modules\becas\models\Becaocupacionpersona;
use app\modules\becas\models\Becapersona;
use app\modules\becas\models\Becasolicitante;
use app\modules\becas\models\Becasolicitud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * BecaconvivienteController implements the CRUD actions for Becaconviviente model.
 */
class BecaconvivienteController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    
    public function actionCreate($s)
    {
        $solicitud = Becasolicitud::find()->where(['token' => $s])->one();

        if($solicitud->convocatoria0->becaconvocatoriaestado == 2){
            return '<div>No se puede modificar ya que la convocatoria está cerrada</div>';
        }

        if($solicitud == null){
            return '<div>No corresponde a una solicitud válida</div>';
        }
        if($solicitud->estado != 1 && $solicitud->estado != 2){
            return '<div class="info">No puede modificar los datos ya que están siendo procesados por la Institución. Si desea modificar algun dato deberá comunicarse directamente con el personal del Colegio.</div>';
        }
        $model = new Becaconviviente();
        $ocupaciones = Becaocupacion::find()->all();
        $nivelestudio = Becanivelestudio::find()->all();
        $ayudasestatal = Becaayudaestatal::find()->all();
        $parentescos = Parentesco::find()->all();

        

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');

            $images = UploadedFile::getInstances($model, 'image');
            


            $nacalumno = explode("/",$model->fechanac);
            $newdatealumno = date("Y-m-d", mktime(0, 0, 0, $nacalumno[1], $nacalumno[0], $nacalumno[2]));
            $model->fechanac = $newdatealumno;

            
            $persona = new Becapersona();
            $persona->save();
            
            $model->persona = $persona->id;
            
            $solicitud = Becasolicitud::find()->where(['token' => $s])->one();
            $model->solicitud = $solicitud->id;
            
            $model->save();
            

            foreach ($model->ocupaciones as $ocupacionx) {
                $ocuX = new Becaocupacionpersona();
                $ocuX->persona = $model->persona;
                $ocuX->ocupacion = $ocupacionx;
                $ocuX->save();
            }

            foreach ($model->ayudas as $ayudax) {
                $ayuX = new Becaayudapersona();
                $ayuX->persona = $model->persona;
                $ayuX->ayuda = $ayudax;
                $ayuX->save();
            }

           

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosAL = new Becanegativaanses();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosAL->nombre = $image->name;
                    $modelajuntosAL->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosAL->persona = $model->persona;
                    $modelajuntosAL->solicitud = $solicitud->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/negativaansesFMfcgzGkXSTfLSXK/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosAL->url;
                    $image->saveAs($path);
                    $modelajuntosAL->save();
                    $model->negativaanses = $modelajuntosAL->id;
                    $model->save();
                    
                }
                
            }

            return $this->redirect(['/becas/default/grupofamiliar', 's' => $solicitud->token]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'ocupaciones' => $ocupaciones,
            'nivelestudio' => $nivelestudio,
            'ayudasestatal' => $ayudasestatal,
            
            'parentescos' => $parentescos,
        ]);
    }

    /**
     * Updates an existing Becaconviviente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $solicitud = Becasolicitud::find()->where(['token' => $model->solicitud0->token])->one();

        if($solicitud->convocatoria0->becaconvocatoriaestado == 2){
            return '<div>No se puede modificar ya que la convocatoria está cerrada</div>';
        }

        if($solicitud == null){
            return '<div>No corresponde a una solicitud válida</div>';
        }
        if($solicitud->estado != 1 && $solicitud->estado != 2){
            return '<div class="info">No puede modificar los datos ya que están siendo procesados por la Institución. Si desea modificar algun dato deberá comunicarse directamente con el personal del Colegio.</div>';
        }
        $ocupaciones = Becaocupacion::find()->all();
        $nivelestudio = Becanivelestudio::find()->all();
        $ayudasestatal = Becaayudaestatal::find()->all();
        $parentescos = Parentesco::find()->all();

        $ocupacionesx = ArrayHelper::map($model->persona0->becaocupacionpersonas, 'ocupacion', 'ocupacion');
        $model->ocupaciones = $ocupacionesx;

        $ayudasx = ArrayHelper::map($model->persona0->becaayudapersonas, 'ayuda', 'ayuda');
        $model->ayudas = $ayudasx;
        try {
            $model->image = $model->negativaanses0->nombre;
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        if ($model->load(Yii::$app->request->post())) {

            $images = UploadedFile::getInstances($model, 'image');

            $explode = explode("/",$model->fechanac);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fechanac = $newdate;

            $acupacionesaborrar = Becaocupacionpersona::find()->where(['persona' => $model->persona])->all();
                foreach ($acupacionesaborrar as $ocupaaborrar) {
                    $ocupaaborrar->delete();
                }
                foreach ($model->ocupaciones as $ocupacionx) {
                    $ocuX = new Becaocupacionpersona();
                    $ocuX->persona = $model->persona;
                    $ocuX->ocupacion = $ocupacionx;
                    $ocuX->save();
                }

                $ayudasborrar = Becaayudapersona::find()->where(['persona' => $model->persona])->all();
                foreach ($ayudasborrar as $ayudaaborrar) {
                    $ayudaaborrar->delete();
                }
    
                foreach ($model->ayudas as $ayudax) {
                    $ayuX = new Becaayudapersona();
                    $ayuX->persona = $model->persona;
                    $ayuX->ayuda = $ayudax;
                    $ayuX->save();
                }

            $conviv = Becasolicitante::find()->where(['persona' => $model->persona])->one();
            if($conviv != null){
                $conviv->apellido = $model->apellido;
                $conviv->nombre = $model->nombre;
                $conviv->cuil = $model->cuil;
                $conviv->fechanac = $model->fechanac;
                $conviv->nivelestudio = $model->nivelestudio;
                $conviv->parentesco = $model->parentesco;
                $conviv->persona = $model->persona;
                $conviv->ocupaciones = $model->ocupaciones;
                $conviv->ayudas = $model->ayudas;
                $conviv->negativaanses = $model->negativaanses;
                $conviv->save();
            }

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosAL = new Becanegativaanses();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosAL->nombre = $image->name;
                    $modelajuntosAL->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosAL->persona = $model->persona;
                    $modelajuntosAL->solicitud = $model->solicitud;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/negativaansesFMfcgzGkXSTfLSXK/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosAL->url;
                    $image->saveAs($path);
                    $modelajuntosAL->save();
                    $model->negativaanses = $modelajuntosAL->id;
                    $model->save();

                    if($conviv != null){
                        
                        $conviv->negativaanses = $model->negativaanses;
                        $conviv->ocupaciones =0;
                        $conviv->ayudas = 0;
                        $conviv->save();
                        
                    }
                    
                }
                
            }

            $model->save();   
                

            return $this->redirect(['/becas/default/grupofamiliar', 's' => $model->solicitud0->token]);
        }

        $fechaexplode = explode("-",$model->fechanac);
        $newdatefecha = date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0]));
        $model->fechanac = $newdatefecha;

        return $this->renderAjax('update', [
            'model' => $model,
            'ocupaciones' => $ocupaciones,
            'nivelestudio' => $nivelestudio,
            'ayudasestatal' => $ayudasestatal,
            
            'parentescos' => $parentescos,
        ]);
    }

    /**
     * Deletes an existing Becaconviviente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $solicitud = Becasolicitud::find()->where(['token' => $model->solicitud0->token])->one();

        if($solicitud->convocatoria0->becaconvocatoriaestado == 2){
            Yii::$app->session->setFlash('danger', "No se encuentra habilitada ninguna convocatoria a becas");
            return $this->redirect(['/becas/default/error']);
        }

        if($solicitud == null){
            Yii::$app->session->setFlash('danger', "No corresponde a una solicitud válida.");
            return $this->redirect(['index']);
        }
        if($solicitud->estado != 1 && $solicitud->estado != 2){
            Yii::$app->session->setFlash('danger', "No puede modificar los datos ya que están siendo procesados por la Institución. Si desea modificar algun dato deberá comunicarse directamente con el personal del Colegio.");
            return $this->redirect(['/becas/default/grupofamiliar', 's' => $model->solicitud0->token]);
        }
        $model->delete();

        return $this->redirect(['/becas/default/grupofamiliar', 's' => $model->solicitud0->token]);
    }

    /**
     * Finds the Becaconviviente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Becaconviviente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Becaconviviente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
