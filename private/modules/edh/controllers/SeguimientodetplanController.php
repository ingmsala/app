<?php

namespace app\modules\edh\controllers;

use app\models\Agente;
use Yii;
use app\modules\edh\models\Seguimientodetplan;
use app\modules\edh\models\SeguimientodetplanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguimientodetplanController implements the CRUD actions for Seguimientodetplan model.
 */
class SeguimientodetplanController extends Controller
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
     * Lists all Seguimientodetplan models.
     * @return mixed
     */
    public function actionIndex($det)
    {
        $searchModel = new SeguimientodetplanSearch();
        $dataProvider = $searchModel->porDetalle($det);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seguimientodetplan model.
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
     * Creates a new Seguimientodetplan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($det)
    {
        $model = new Seguimientodetplan();
        $model->detalleplan = $det;
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $model->creado = $agente->id;

        if ($model->load(Yii::$app->request->post())) {

            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            
            $plazoexplode = explode("/",$model->plazo);
            $newdateplazo = date("Y-m-d", mktime(0, 0, 0, $plazoexplode[1], $plazoexplode[0], $plazoexplode[2]));
            $model->plazo = $newdateplazo;
            
            $model->save();

            return $this->redirect(['plancursado/view', 'id' => $model->detalleplan0->plan, 'ref' => $model->detalleplan]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Seguimientodetplan model.
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
            
            $plazoexplode = explode("/",$model->plazo);
            $newdateplazo = date("Y-m-d", mktime(0, 0, 0, $plazoexplode[1], $plazoexplode[0], $plazoexplode[2]));
            $model->plazo = $newdateplazo;

            $model->save();

            return $this->redirect(['plancursado/view', 'id' => $model->detalleplan0->plan, 'ref' => $model->detalleplan]);
        }

        $fechaexplode = explode("-",$model->fecha);
        $newdatefecha = (!empty($model->fecha)) ? date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0])) : null;
        $model->fecha = $newdatefecha;

        $plazoexplode = explode("-",$model->plazo);
        $newdateplazo = (!empty($model->plazo)) ? date("d/m/Y", mktime(0, 0, 0, $plazoexplode[1], $plazoexplode[2], $plazoexplode[0])) : null;
        $model->plazo = $newdateplazo;

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Seguimientodetplan model.
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
     * Finds the Seguimientodetplan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguimientodetplan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguimientodetplan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
