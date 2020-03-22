<?php

namespace app\modules\sociocomunitarios\controllers;

use app\models\Turno;
use Yii;
use app\modules\curriculares\models\Admisionsociocom;
use app\modules\curriculares\models\AdmisionsociocomSearch;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdmisionsociocomController implements the CRUD actions for Admisionsociocom model.
 */
class AdmisionsociocomController extends Controller
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
     * Lists all Admisionsociocom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdmisionsociocomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admisionsociocom model.
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
     * Creates a new Admisionsociocom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admisionsociocom();
        $aniolectivos = Aniolectivo::find()->all();
        $alumnos = Alumno::find()->all();
        $turnos = Turno::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'aniolectivos' => $aniolectivos,
            'alumnos' => $alumnos,
            'turnos' => $turnos,
        ]);
    }

    /**
     * Updates an existing Admisionoptativa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $aniolectivos = Aniolectivo::find()->all();
        $alumnos = Alumno::find()->all();
        $turnos = Turno::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'aniolectivos' => $aniolectivos,
            'alumnos' => $alumnos,
            'turnos' => $turnos,
        ]);
    }

    /**
     * Deletes an existing Admisionsociocom model.
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
     * Finds the Admisionsociocom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admisionsociocom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admisionsociocom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
