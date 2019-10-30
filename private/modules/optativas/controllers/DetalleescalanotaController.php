<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Condicionnota;
use app\modules\optativas\models\Detalleescalanota;
use app\modules\optativas\models\DetalleescalanotaSearch;
use app\modules\optativas\models\Escalanota;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DetalleescalanotaController implements the CRUD actions for Detalleescalanota model.
 */
class DetalleescalanotaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Detalleescalanota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleescalanotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detalleescalanota model.
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
     * Creates a new Detalleescalanota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($en)
    {
        $model = new Detalleescalanota();
        $condiciones = Condicionnota::find()->all();
        $escalas = Escalanota::find()->where(['id' => $en])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/optativas/escalanota/view', 'id' => $model->escalanota]);
        }

        return $this->render('create', [
            'model' => $model,
            'escalas' => $escalas,
            'condiciones' => $condiciones,
        ]);
    }

    /**
     * Updates an existing Detalleescalanota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $condiciones = Condicionnota::find()->all();
        $escalas = Escalanota::find()->where(['id' => $model->escalanota])->all();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/optativas/escalanota/view', 'id' => $model->escalanota]);
        }

        return $this->render('update', [
            'model' => $model,
            'escalas' => $escalas,
            'condiciones' => $condiciones,
        ]);
    }

    /**
     * Deletes an existing Detalleescalanota model.
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
     * Finds the Detalleescalanota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleescalanota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleescalanota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
