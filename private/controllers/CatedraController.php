<?php

namespace app\controllers;

use Yii;
use app\models\Catedra;
use app\models\CatedraSearch;
use app\models\Actividad;
use app\models\Division;
use app\models\Propuesta;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DetalleCatedra;
use app\models\DetalleCatedraSearch;
use yii\filters\AccessControl;

/**
 * CatedraController implements the CRUD actions for Catedra model.
 */
class CatedraController extends Controller
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
                        
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Catedra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatedraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Catedra model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new DetalleCatedraSearch();
        $dataProvider = $searchModel->providerxcatedra($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalle' => DetalleCatedra::find()->where([
                'catedra' => $id,
                
            ])->one(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Catedra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Catedra();
        $modelpropuesta = new Propuesta();

        $actividades=Actividad::find()->all();
        $divisiones=Division::find()->all();
        $propuestas=Propuesta::find()->all();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelpropuesta' => $modelpropuesta, 
            'actividades' => $actividades,
            'divisiones' => $divisiones,
            'propuestas' => $propuestas,
        ]);
    }

    /**
     * Updates an existing Catedra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelpropuesta = new Propuesta();
        
        $actividades=Actividad::find()->all();
        $divisiones=Division::find()->all();
        $propuestas=Propuesta::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelpropuesta' => $modelpropuesta,
            'actividades' => $actividades,
            'divisiones' => $divisiones,
            'propuestas' => $propuestas,
        ]);
    }

    /**
     * Deletes an existing Catedra model.
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
     * Finds the Catedra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catedra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catedra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    
}
