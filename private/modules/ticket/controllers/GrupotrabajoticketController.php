<?php

namespace app\modules\ticket\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\ticket\models\Areaticket;
use Yii;
use app\modules\ticket\models\Grupotrabajoticket;
use app\modules\ticket\models\GrupotrabajoticketSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrupotrabajoticketController implements the CRUD actions for Grupotrabajoticket model.
 */
class GrupotrabajoticketController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Grupotrabajoticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GrupotrabajoticketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grupotrabajoticket model.
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
     * Creates a new Grupotrabajoticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($area)
    {
        $model = new Grupotrabajoticket();
        $model->areaticket = $area;
        $agentes=Agente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $areas=Areaticket::find()->where(['activo' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->areaticket = $area;
            $model->save();
            return $this->redirect(['areaticket/view', 'area' => $model->areaticket]);
        }

        return $this->render('create', [
            'model' => $model,
            'agentes' => $agentes,
            'areas' => $areas,
        ]);
    }

    /**
     * Updates an existing Grupotrabajoticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $area = $model->areaticket;

        $agentes=Agente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $areas=Areaticket::find()->where(['activo' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->areaticket = $area;
            $model->save();
            return $this->redirect(['areaticket/view', 'area' => $model->areaticket]);
        }

        return $this->render('update', [
            'model' => $model,
            'agentes' => $agentes,
            'areas' => $areas,
        ]);
    }

    /**
     * Deletes an existing Grupotrabajoticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $area = $model->areaticket;
        $model->delete();

        return $this->redirect(['areaticket/view', 'area' => $area]);
    }

    /**
     * Finds the Grupotrabajoticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grupotrabajoticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grupotrabajoticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
