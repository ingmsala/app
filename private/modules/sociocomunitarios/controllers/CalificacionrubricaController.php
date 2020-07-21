<?php

namespace app\modules\sociocomunitarios\controllers;

use app\modules\curriculares\models\Detalleescalanota;
use Yii;
use app\modules\sociocomunitarios\models\Calificacionrubrica;
use app\modules\sociocomunitarios\models\CalificacionrubricaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalificacionrubricaController implements the CRUD actions for Calificacionrubrica model.
 */
class CalificacionrubricaController extends Controller
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
     * Lists all Calificacionrubrica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalificacionrubricaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calificacionrubrica model.
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
     * Creates a new Calificacionrubrica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($rubrica)
    {
        $model = new Calificacionrubrica();
        $model->rubrica = $rubrica;

        $detalleescalas = Detalleescalanota::find()->where(['escalanota' => 5])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['rubrica/view', 'id' => $model->rubrica]);
        }

        return $this->render('create', [
            'model' => $model,
            'detalleescalas' => $detalleescalas,
        ]);
    }

    /**
     * Updates an existing Calificacionrubrica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $detalleescalas = Detalleescalanota::find()->where(['escalanota' => 5])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['rubrica/view', 'id' => $model->rubrica]);
        }

        return $this->render('update', [
            'model' => $model,
            'detalleescalas' => $detalleescalas,
        ]);
    }

    /**
     * Deletes an existing Calificacionrubrica model.
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
     * Finds the Calificacionrubrica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calificacionrubrica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calificacionrubrica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
