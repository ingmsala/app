<?php

namespace app\modules\becas\controllers;

use app\models\Parentesco;
use app\modules\becas\models\Becaayudaestatal;
use app\modules\becas\models\Becaayudapersona;
use app\modules\becas\models\Becaconviviente;
use app\modules\becas\models\Becanegativaanses;
use app\modules\becas\models\Becanivelestudio;
use app\modules\becas\models\Becaocupacion;
use app\modules\becas\models\Becaocupacionpersona;
use Yii;
use app\modules\becas\models\Becasolicitante;
use app\modules\becas\models\BecasolicitanteSearch;
use app\modules\becas\models\Becasolicitud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * BecasolicitanteController implements the CRUD actions for Becasolicitante model.
 */
class BecasolicitanteController extends Controller
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

    
    /**
     * Updates an existing Becasolicitante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $s)
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
        $model = $this->findModel($id);

        $ocupaciones = Becaocupacion::find()->all();
        $nivelestudio = Becanivelestudio::find()->all();
        $ayudasestatal = Becaayudaestatal::find()->all();
        

        
        $parentescos = Parentesco::find()
                        ->where(['in', 'id', [1,2,9,10]])                
                        ->all();

        $ocupacionesx = ArrayHelper::map($model->persona0->becaocupacionpersonas, 'ocupacion', 'ocupacion');
        $model->ocupaciones = $ocupacionesx;

        $ayudasx = ArrayHelper::map($model->persona0->becaayudapersonas, 'ayuda', 'ayuda');
        $model->ayudas = $ayudasx;

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

            $model->save(); 

            $conviv = Becaconviviente::find()->where(['persona' => $model->persona])->one();
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
                    $modelajuntosAL->solicitud = $solicitud->id;
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
                

            return $this->redirect(['/becas/default/solicitud', 's' => $s]);
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
     * Finds the Becasolicitante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Becasolicitante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Becasolicitante::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
