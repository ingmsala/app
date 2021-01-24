<?php

namespace app\modules\edh\controllers;

use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Adjuntocertificacion;
use app\modules\edh\models\AdjuntocertificacionSearch;
use Yii;
use app\modules\edh\models\Certificacionedh;
use app\modules\edh\models\CertificacionedhSearch;
use app\modules\edh\models\InformeprofesionalSearch;
use app\modules\edh\models\Tipocertificacion;
use app\modules\edh\models\Tipoprofesional;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CertificacionedhController implements the CRUD actions for Certificacionedh model.
 */
class CertificacionedhController extends Controller
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
     * Lists all Certificacionedh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificacionedhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPorsolicitud()
    {
        if (isset($_POST['expandRowKey'])) {
            $solicitud = $_POST['expandRowKey'];
            $searchModel = new CertificacionedhSearch();
            $dataProvider = $searchModel->porSolicitud($solicitud);

            $searchModelInforme = new InformeprofesionalSearch();
            $dataProviderInforme = $searchModelInforme->porSolicitud($solicitud);

        } else {
            $searchModel = null;
            $dataProvider = null;
            $searchModelInforme = null;
            $dataProviderInforme = null;
            $solicitud = 0;
        }
        

        return $this->renderPartial('porsolicitud', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelInforme' => $searchModelInforme,
            'dataProviderInforme' => $dataProviderInforme,
            'solicitud' => $solicitud,
        ]);
    }

    /**
     * Displays a single Certificacionedh model.
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
     * Creates a new Certificacionedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($solicitud)
    {
        $model = new Certificacionedh();
        $model->solicitud = $solicitud;
        $modelajuntos = new Adjuntocertificacion();

        $tiposcertificado = Tipocertificacion::find()->all();
        $tiposprofesional = Tipoprofesional::find()->all();

        $certificados = Certificacionedh::find()->all();

        $referentes = array_column($certificados,'referente');
        $instituciones = array_column($certificados,'institucion');
        $diagnosticos = array_column($certificados,'diagnostico');

        if ($model->load(Yii::$app->request->post()) && $modelajuntos->load(Yii::$app->request->post())) {

            $images = UploadedFile::getInstances($modelajuntos, 'image');

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $vencimientoexplode = explode("/",$model->vencimiento);
            $newdatevencimiento = (!empty($model->vencimiento)) ? date("Y-m-d", mktime(0, 0, 0, $vencimientoexplode[1], $vencimientoexplode[0], $vencimientoexplode[2])) : null;
            $model->vencimiento = $newdatevencimiento;

            $model->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->solicitud0->caso, 3, 'Se crea la certificación #'.$model->id, 1);

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosX = new Adjuntocertificacion();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosX->nombre = $image->name;
                    $modelajuntosX->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosX->certificacion = $model->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/certificados3d7WLzEjbpKjr0K/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosX->url;
                    $image->saveAs($path);
                    $modelajuntosX->save();
                    
                }
                
            }

            Yii::$app->session->setFlash('success', "Se registró correctamente la certificación");

            return $this->redirect(['/edh/solicitudedh/index', 'id' => $model->solicitud0->caso, 'sol' => $solicitud]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modelajuntos' => $modelajuntos,
            'tiposcertificado' => $tiposcertificado,
            'tiposprofesional' => $tiposprofesional,
            'referentes' => $referentes,
            'instituciones' => $instituciones,
            'diagnosticos' => $diagnosticos,
        ]);
    }

    /**
     * Updates an existing Certificacionedh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelajuntos = new Adjuntocertificacion();

        $tiposcertificado = Tipocertificacion::find()->all();
        $tiposprofesional = Tipoprofesional::find()->all();

        $certificados = Certificacionedh::find()->all();

        $referentes = array_column($certificados,'referente');
        $instituciones = array_column($certificados,'institucion');
        $diagnosticos = array_column($certificados,'diagnostico');

        if ($model->load(Yii::$app->request->post())) {

            $images = UploadedFile::getInstances($modelajuntos, 'image');

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $vencimientoexplode = explode("/",$model->vencimiento);
            $newdatevencimiento = (!empty($model->vencimiento)) ? date("Y-m-d", mktime(0, 0, 0, $vencimientoexplode[1], $vencimientoexplode[0], $vencimientoexplode[2])) : null;
            $model->vencimiento = $newdatevencimiento;

            $model->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->solicitud0->caso, 3, 'Se modifica la certificación #'.$model->id, 0);

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosX = new Adjuntocertificacion();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosX->nombre = $image->name;
                    $modelajuntosX->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosX->certificacion = $model->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/certificados3d7WLzEjbpKjr0K/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosX->url;
                    $image->saveAs($path);
                    $modelajuntosX->save();
                    
                }
                
            }

            Yii::$app->session->setFlash('success', "Se modificó correctamente la certificación");

            return $this->redirect(['/edh/solicitudedh/index', 'id' => $model->solicitud0->caso, 'sol' => $model->solicitud]);
        }

        $fechaexplode = explode("-",$model->fecha);
        $newdatefecha = (!empty($model->fecha)) ? date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0])) : null;
        $model->fecha = $newdatefecha;

        $vencimientoexplode = explode("-",$model->vencimiento);
        $newdatevencimiento = (!empty($model->vencimiento)) ? date("d/m/Y", mktime(0, 0, 0, $vencimientoexplode[1], $vencimientoexplode[2], $vencimientoexplode[0])) : null;
        $model->vencimiento = $newdatevencimiento;

        $searchModelAdjuntos = new AdjuntocertificacionSearch();
        $dataProviderAdjuntos = $searchModelAdjuntos->porCertificado($id);
        
        return $this->renderAjax('update', [
            'model' => $model,
            'modelajuntos' => $modelajuntos,
            'tiposcertificado' => $tiposcertificado,
            'tiposprofesional' => $tiposprofesional,
            'referentes' => $referentes,
            'instituciones' => $instituciones,
            'diagnosticos' => $diagnosticos,
            'searchModelAdjuntos' => $searchModelAdjuntos,
            'dataProviderAdjuntos' => $dataProviderAdjuntos,
        ]);
    }

    /**
     * Deletes an existing Certificacionedh model.
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
     * Finds the Certificacionedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Certificacionedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Certificacionedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
