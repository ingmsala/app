<?php

namespace app\controllers;

use app\models\Declaracionjurada;
use Yii;
use app\models\Mensajedj;
use app\models\MensajedjSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensajedjController implements the CRUD actions for Mensajedj model.
 */
class MensajedjController extends Controller
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
     * Lists all Mensajedj models.
     * @return mixed
     */
    public function actionIndex($dj)
    {
        $searchModel = new MensajedjSearch();
        $dataProvider = $searchModel->search($dj);

        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single Mensajedj model.
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
     * Creates a new Mensajedj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dj)
    {
        $model = new Mensajedj();
        $model->declaracionjurada = $dj;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model->fecha = date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $decl = Declaracionjurada::findOne($dj);
            $decl->estadodeclaracion = 4;
            $decl->save();

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mensajedj model.
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
     * Deletes an existing Mensajedj model.
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
     * Finds the Mensajedj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mensajedj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensajedj::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
