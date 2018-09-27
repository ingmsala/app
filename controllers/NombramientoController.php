<?php

namespace app\controllers;

use Yii;
use app\models\Nombramiento;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cargo;
use app\models\Docente;
use app\models\Revista;
use app\models\Division;
use app\models\Condicion;
use yii\helpers\ArrayHelper;

/**
 * NombramientoController implements the CRUD actions for Nombramiento model.
 */
class NombramientoController extends Controller
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
     * Lists all Nombramiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NombramientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nombramiento model.
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
     * Creates a new Nombramiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nombramiento();


        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->all();
        $revistas = Revista::find()->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->all();
        $suplentes = Nombramiento::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            'suplentes' => $suplentes,
        ]);
    }

    /**
     * Updates an existing Nombramiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->all();
        $revistas = Revista::find()->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->all();
        $suplentes = Nombramiento::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            'suplentes' => $suplentes,
        ]);
    }

    /**
     * Deletes an existing Nombramiento model.
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
     * Finds the Nombramiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nombramiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nombramiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

        public function actionAsignarsuplente()
    {
        
        $cargox = $_REQUEST['cargox'];
        $idx = $_REQUEST['idx'];

        $model = Nombramiento::findOne($idx);
        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->all();
        $revistas = Revista::find()->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->all();
        $suplentes = Nombramiento::find()
            ->where(['cargo'=>$cargox,])
            ->andWhere(['<>','id', $idx])
            ->all();
       
         $suplente = ArrayHelper::toArray($suplentes, [
        'app\models\Nombramiento' => [
            'id',
            'nombre' => function ($supl) {
             return $supl->getLabel();
            }],
         ]);

         
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('createsuplente', [
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            'suplentes' => $suplente,
        ]);
    }
}
