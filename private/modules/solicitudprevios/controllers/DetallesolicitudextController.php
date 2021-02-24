<?php

namespace app\modules\solicitudprevios\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\Turnoexamen;
use Yii;
use app\modules\solicitudprevios\models\Detallesolicitudext;
use app\modules\solicitudprevios\models\DetallesolicitudextSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetallesolicitudextController implements the CRUD actions for Detallesolicitudext model.
 */
class DetallesolicitudextController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'pormateria'],
                'rules' => [
                    [
                        'actions' => ['index', 'pormateria'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) || in_array (Yii::$app->user->identity->username, Globales::solicitudesext))
                                    return true;
                                return false;
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view', 'create', 'update', 'delete'],   
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
     * Lists all Detallesolicitudext models.
     * @return mixed
     */
    public function actionIndex($turno)
    {
        $searchModel = new DetallesolicitudextSearch();
        $dataProvider = $searchModel->search($turno);
        $turno = Turnoexamen::findOne($turno);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'turno' => $turno,
        ]);
    }
    public function actionPormateria($turno, $actividad)
    {
        $searchModel = new DetallesolicitudextSearch();
        $dataProvider = $searchModel->pormateria($turno, $actividad);
        $tur = Turnoexamen::findOne($turno);
        $act = Actividad::findOne($actividad);
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'turno' => $tur,
            'act' => $act,
        ]);
    }

    /**
     * Displays a single Detallesolicitudext model.
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
     * Creates a new Detallesolicitudext model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Detallesolicitudext();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Detallesolicitudext model.
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
     * Deletes an existing Detallesolicitudext model.
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
     * Finds the Detallesolicitudext model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detallesolicitudext the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detallesolicitudext::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
