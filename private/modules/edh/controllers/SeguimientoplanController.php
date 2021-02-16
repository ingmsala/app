<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\modules\edh\models\Caso;
use Yii;
use app\modules\edh\models\Seguimientoplan;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguimientoplanController implements the CRUD actions for Seguimientoplan model.
 */
class SeguimientoplanController extends Controller
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
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION]);
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
     * Lists all Seguimientoplan models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new SeguimientoplanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Seguimientoplan model.
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
     * Creates a new Seguimientoplan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($plan)
    {
        $model = new Seguimientoplan();
        $model->plan = $plan;

        if ($model->load(Yii::$app->request->post())) {

            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            $model->save();

            Yii::$app->session->setFlash('success', 'Se creó correctamente el seguimiento');
            return $this->redirect(['plancursado/index', 'caso' => $model->plan0->caso]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Seguimientoplan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            $model->save();

            Yii::$app->session->setFlash('success', 'Se actualizó correctamente el seguimiento');
            return $this->redirect(['plancursado/index', 'caso' => $model->plan0->caso]);
        }

        $fechaexplode = explode("-",$model->fecha);
        $newdatefecha = (!empty($model->fecha)) ? date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0])) : null;
        $model->fecha = $newdatefecha;

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Seguimientoplan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $caso = $model->plan0->caso;
        $model->delete();
        Yii::$app->session->setFlash('success', 'Se eliminó correctamente el seguimiento');
        return $this->redirect(['plancursado/index', 'caso' => $caso]);
    }

    /**
     * Finds the Seguimientoplan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguimientoplan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguimientoplan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
