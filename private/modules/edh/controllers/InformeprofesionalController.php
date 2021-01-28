<?php

namespace app\modules\edh\controllers;


use Yii;
use app\models\Agente;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Areasolicitud;
use app\modules\edh\models\Informeprofesional;
use app\modules\edh\models\InformeprofesionalSearch;
use app\modules\edh\models\Solicitudedh;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InformeprofesionalController implements the CRUD actions for Informeprofesional model.
 */
class InformeprofesionalController extends Controller
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
     * Lists all Informeprofesional models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InformeprofesionalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Informeprofesional model.
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
     * Creates a new Informeprofesional model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($solicitud)
    {
        $model = new Informeprofesional();
        $model->solicitud = $solicitud;

        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $model->agente = $agente->id;
        $areas = Areasolicitud::find()->where(['in', 'id', [2,3]])->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            

            $model->save();

            
            $modelSolicitud = Solicitudedh::findOne($solicitud);
            $modelSolicitud->estadosolicitud = 2;
            $modelSolicitud->save();

            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->solicitud0->caso, 3, 'Se crea el informe profesional #'.$model->id.' y se cambia el estado de la solicitud a '.$modelSolicitud->estadosolicitud0->nombre, 1);

            Yii::$app->session->setFlash('success', 'Se generó correctamente el informe');
            return $this->redirect(['/edh/solicitudedh/index', 'id' => $model->solicitud0->caso, 'sol' => $solicitud]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'areas' => $areas,
        ]);
    }

    /**
     * Updates an existing Informeprofesional model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $areas = Areasolicitud::find()->where(['in', 'id', [2,3]])->all();

        if ($model->load(Yii::$app->request->post())) {
            $fechaexplode = explode("/",$model->fecha);
            $newdatefecha = (!empty($model->fecha)) ? date("Y-m-d", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[0], $fechaexplode[2])) : null;
            $model->fecha = $newdatefecha;
            $model->save();
            Yii::$app->session->setFlash('success', 'Se actualizó correctamente el informe');
            return $this->redirect(['/edh/solicitudedh/index', 'id' => $model->solicitud0->caso, 'sol' => $model->solicitud]);
        }

        $fechaexplode = explode("-",$model->fecha);
        $newdatefecha = (!empty($model->fecha)) ? date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0])) : null;
        $model->fecha = $newdatefecha;

        return $this->renderAjax('update', [
            'model' => $model,
            'areas' => $areas,
        ]);
    }

    /**
     * Deletes an existing Informeprofesional model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $solicitud = $model->solicitud0;

        $model->delete();

        Yii::$app->session->setFlash('success', 'Se eliminó correctamente el informe');

        return $this->redirect(['/edh/solicitudedh/index', 'id' => $solicitud->caso, 'sol' => $solicitud->id]);

    }

    /**
     * Finds the Informeprofesional model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Informeprofesional the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Informeprofesional::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
