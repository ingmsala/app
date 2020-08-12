<?php

namespace app\controllers;

use app\models\Departamento;
use app\models\Docente;
use Yii;
use app\models\Docentexdepartamento;
use app\models\DocentexdepartamentoSearch;
use app\models\Funciondpto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocentexdepartamentoController implements the CRUD actions for Docentexdepartamento model.
 */
class DocentexdepartamentoController extends Controller
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
     * Lists all Docentexdepartamento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocentexdepartamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docentexdepartamento model.
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
     * Creates a new Docentexdepartamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dpto)
    {
        $model = new Docentexdepartamento();
        $model->departamento = $dpto;
        $departamentos = Departamento::find()->where(['id' => $dpto])->all();
        $docentes = Docente::find()->orderBy('apellido, nombre')->all();
        $funciones = Funciondpto::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'departamentos' => $departamentos,
            'docentes' => $docentes,
            'funciones' => $funciones,
        ]);
    }

    /**
     * Updates an existing Docentexdepartamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $departamentos = Departamento::find()->where(['id' => $model->departamento])->all();
        $docentes = Docente::find()->orderBy('apellido, nombre')->all();
        $funciones = Funciondpto::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'departamentos' => $departamentos,
            'docentes' => $docentes,
            'funciones' => $funciones,
        ]);
    }

    /**
     * Deletes an existing Docentexdepartamento model.
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
     * Finds the Docentexdepartamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Docentexdepartamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docentexdepartamento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
