<?php

namespace app\modules\edh\controllers;

use Yii;
use app\modules\edh\models\Adjuntocertificacion;
use app\modules\edh\models\AdjuntocertificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdjuntocertificacionController implements the CRUD actions for Adjuntocertificacion model.
 */
class AdjuntocertificacionController extends Controller
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
     * Lists all Adjuntocertificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdjuntocertificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adjuntocertificacion model.
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

    public function actionDescargar($file)
    {
        
        $model = Adjuntocertificacion::find()->where(['url' => $file])->one();

        $path = Yii::getAlias('@webroot') . '/assets/images/certificados3d7WLzEjbpKjr0K/'.$file;

        $file = $path;

        if (file_exists($file)) {

            Yii::$app->response->sendFile($file, $model->nombre);
        }

    }

    /**
     * Creates a new Adjuntocertificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adjuntocertificacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adjuntocertificacion model.
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
     * Deletes an existing Adjuntoticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post()['id'];
        $model = $this->findModel($id);

        if($model->certificacion0->solicitud0->caso0->estadocaso == 2){
            return Yii::$app->session->setFlash('danger', '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>');
        }
        
        //$idx = $model->ticket;

        Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/certificados3d7WLzEjbpKjr0K/';
        $archivo = Yii::$app->params['uploadPath'] . $model->url;

        unlink($archivo);
        $model->delete();

        //return $this->redirect(['/ticket/'.$redirigir.'/update/', 'id'=>$idx]);
    }

    /**
     * Finds the Adjuntocertificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjuntocertificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjuntocertificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
