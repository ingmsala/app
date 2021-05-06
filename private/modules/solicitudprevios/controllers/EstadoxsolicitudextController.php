<?php

namespace app\modules\solicitudprevios\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\solicitudprevios\models\Detallesolicitudext;
use Yii;
use app\modules\solicitudprevios\models\Estadoxsolicitudext;
use app\modules\solicitudprevios\models\EstadoxsolicitudextSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstadoxsolicitudextController implements the CRUD actions for Estadoxsolicitudext model.
 */
class EstadoxsolicitudextController extends Controller
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
                        'actions' => ['index', 'create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                            if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_DESPACHO])){
                                return true;
                            }
                            return false;
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
     * Lists all Estadoxsolicitudext models.
     * @return mixed
     */
    public function actionIndex($det)
    {
        $searchModel = new EstadoxsolicitudextSearch();
        $dataProvider = $searchModel->search($det);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estadoxsolicitudext model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Estadoxsolicitudext model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($estado, $detalle)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model = new Estadoxsolicitudext();
        $model->estado = $estado;
        $model->detalle = $detalle;
        $model->fecha = date('Y-m-d');
        $ag = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $model->agente = $ag->id;
        if($estado <> 3){
            if($estado == 1){
                $model->motivo = 'Cambio a estado inicial';
            }
            $model->save();
            $det = Detallesolicitudext::findOne($detalle);
            $det->estado = $model->id;
            $det->save();
            return $this->redirect(['detallesolicitudext/control', 'turno' => $det->solicitud0->turno]);
        }

        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $det = Detallesolicitudext::findOne($detalle);
            $det->estado = $model->id;
            $det->save();
            return $this->redirect(['detallesolicitudext/control', 'turno' => $det->solicitud0->turno]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Estadoxsolicitudext model.
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
     * Deletes an existing Estadoxsolicitudext model.
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
     * Finds the Estadoxsolicitudext model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Estadoxsolicitudext the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estadoxsolicitudext::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
