<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\curriculares\models\Admisionoptativa;
use app\modules\curriculares\models\AdmisionoptativaSearch;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdmisionoptativaController implements the CRUD actions for Admisionoptativa model.
 */
class AdmisionoptativaController extends Controller
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
     * Lists all Admisionoptativa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdmisionoptativaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admisionoptativa model.
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
     * Creates a new Admisionoptativa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admisionoptativa();
        $aniolectivos = Aniolectivo::find()->all();
        $alumnos = Alumno::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'aniolectivos' => $aniolectivos,
            'alumnos' => $alumnos,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'aniolectivos' => $aniolectivos,
            'alumnos' => $alumnos,
        ]);
    }

    /**
     * Deletes an existing Admisionoptativa model.
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

    /*public function actionAdduno()
    {
        $admision20 = Admisionoptativa::find()
                        ->where(['aniolectivo' => 2])
                        ->all();
        
        foreach ($admision20 as $admision) {
            $admision->aniolectivo = $admision->aniolectivo + 1;
            $admision->curso = $admision->curso + 1;
            $admision->save();

        }
        return 'true';

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Admisionoptativa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admisionoptativa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admisionoptativa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
