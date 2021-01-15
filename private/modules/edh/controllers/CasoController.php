<?php

namespace app\modules\edh\controllers;

use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Tutor;
use app\modules\edh\models\Areasolicitud;
use Yii;
use app\modules\edh\models\Caso;
use app\modules\edh\models\CasoSearch;
use app\modules\edh\models\Condicionfinal;
use app\modules\edh\models\Estadocaso;
use app\modules\edh\models\Matriculaedh;
use app\modules\edh\models\Solicitudedh;
use app\modules\edh\models\Tiposolicitud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CasoController implements the CRUD actions for Caso model.
 */
class CasoController extends Controller
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
     * Lists all Caso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $searchModel = new CasoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Caso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Caso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = new Caso();
        $modelSolicitud = new Solicitudedh();

        $model->estadocaso = 1;
        $model->condicionfinal = 1;

        $modelSolicitud->tiposolicitud = 1;
        $modelSolicitud->estadosolicitud = 1;

        $aniolectivos = Aniolectivo::find()->all();
        $areas = Areasolicitud::find()->all();

        if ($model->load(Yii::$app->request->post()) && $modelSolicitud->load(Yii::$app->request->post())) {
           
            $desdeexplode = explode("/",$model->inicio);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->inicio = $newdatedesde;
            
            $model->save();

            $modelSolicitud->fecha = $model->inicio;
            $modelSolicitud->caso = $model->id;

            $modelSolicitud->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelSolicitud' => $modelSolicitud,
            'aniolectivos' => $aniolectivos,
            'areas' => $areas,
        ]);
    }

    public function actionActualizar($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);
        $modelSolicitud = new Solicitudedh();

        $condicionesfinales = Condicionfinal::find()->all();
        $estadoscaso = Estadocaso::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->inicio);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->inicio = $newdatedesde;

            $finexplode = explode("/",$model->fin);
            $newdatefin = (!empty($model->fin)) ? date("d/m/Y", mktime(0, 0, 0, $finexplode[1], $finexplode[2], $finexplode[0])) : null;
            $model->fin = $newdatefin;
            
            $model->save();

           return $this->redirect(['view', 'id' => $model->id]);
        }

        $desdeexplode = explode("-",$model->inicio);
        $newdatedesde = (!empty($model->inicio)) ? date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0])) : null;
        $model->inicio = $newdatedesde;

        $finexplode = explode("-",$model->fin);
        $newdatefin = (!empty($model->fin)) ? date("d/m/Y", mktime(0, 0, 0, $finexplode[1], $finexplode[2], $finexplode[0])) : null;
        $model->fin = $newdatefin;

        return $this->renderAjax('actualizar', [
            'model' => $model,
            'estadoscaso' => $estadoscaso,
            'condicionesfinales' => $condicionesfinales,
        ]);
    }

    /**
     * Updates an existing Caso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Caso model.
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

    public function actionMatriculas()
    {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            
            if ($parents != null) {

                $aniolectivo_id = $parents[0];

                $matriculas = Matriculaedh::find()->where(['aniolectivo' => $aniolectivo_id])->all();
                                
                $listMAtriculas=ArrayHelper::toArray($matriculas, [
                    'app\modules\edh\models\Matriculaedh' => [
                        'id' => function($model) {
                            return $model['id'];},
                        'name' => function($model) {
                            return $model['alumno0']['apellido'].', '.$model['alumno0']['nombre'].' ('.$model['division0']['nombre'].')';},
                    ],
                ]);
                $out = $listMAtriculas;
                
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];

        
        
        
    }

    public function actionDemandantes()
    {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {

            
            
            $parents = $_POST['depdrop_parents'];
            
            $matricula_id = empty($parents[0]) ? null : $parents[0];
            //$matricula_id = $parents[0];
            
            if ($matricula_id != null) {

                

                $matricula = Matriculaedh::findOne($matricula_id);

                $tutores = Tutor::find()->where(['alumno' => $matricula->alumno])->all();
                                
                $listTutores=ArrayHelper::toArray($tutores, [
                    'app\modules\curriculares\models\Tutor' => [
                        'id' => function($model) {
                            return $model['id'];},
                        'name' => function($model) {
                            return $model['apellido'].', '.$model['nombre'].' ('.$model['parentesco'].')';},
                    ],
                ]);
                $out = $listTutores;
                
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];

        
        
        
    }

    /**
     * Finds the Caso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Caso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Caso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
