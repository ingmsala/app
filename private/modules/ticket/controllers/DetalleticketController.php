<?php

namespace app\modules\ticket\controllers;

use app\models\Agente;
use app\modules\ticket\models\Adjuntoticket;
use app\modules\ticket\models\Areaticket;
use app\modules\ticket\models\Asignacionticket;
use Yii;
use app\modules\ticket\models\Detalleticket;
use app\modules\ticket\models\DetalleticketSearch;
use app\modules\ticket\models\Estadoticket;
use app\modules\ticket\models\Ticket;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * DetalleticketController implements the CRUD actions for Detalleticket model.
 */
class DetalleticketController extends Controller
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
     * Lists all Detalleticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleticketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detalleticket model.
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
     * Creates a new Detalleticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ticket)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $ticketModel = Ticket::findOne($ticket);
        $model = new Detalleticket();
        $modelasignacion = new Asignacionticket();
        $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_REQ;
        $modelajuntos = new Adjuntoticket();

        $model->fecha = date('Y-m-d');
        $model->hora = date('H:i');
        $model->ticket = $ticket;
        $creador = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $model->agente = $creador->id;
        $model->estadoticket = ($ticketModel->estadoticket == 2) ? 1 : $ticketModel->estadoticket;

        $areas = Areaticket::find()->all();
        $agentes = Agente::find()->all();
        $asignaciones = [];

        $involucados = Asignacionticket::find()
                        ->joinWith(['detalleticket0', 'ticket0'])
                        ->where(['asignacionticket.ticket' => $ticketModel->id])
                        ->orWhere(['detalleticket.ticket' => $ticketModel->id])
                        ->all();

        $sugerencias = [];
        $sugerencias [$ticketModel->agente] = $ticketModel->agente0->apellido.', '.$ticketModel->agente0->nombre;
        $ultimaasignacion = 0;
        //$detallestic = $ticketModel->detalletickets;
        foreach ($involucados as $detalle) {
            //$sugerencias [$detalle->agente] = $detalle->agente0->apellido.', '.$detalle->agente0->nombre;
            if($detalle->agente == null){
                $sugerencias [-$detalle->areaticket0->id] = $detalle->areaticket0->nombre;
            }else{
                $sugerencias [$detalle->agente0->id] = $detalle->agente0->apellido.', '.$detalle->agente0->nombre;
            }
            $ultimaasignacion = $detalle;
        }

        //return var_dump($involucados);

        if(count($sugerencias)>0)
            $asignaciones ['Sugerencias'] = $sugerencias;       
        $asignacionesAreas = ArrayHelper::map($areas,function($model){return -$model->id;}, 'nombre');
        $asignacionesAreas = array_diff($asignacionesAreas, $asignaciones ['Sugerencias']);

        $asignacionesAgentes = ArrayHelper::map($agentes,function($model){return $model->id;}, function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );
        $asignacionesAgentes = array_diff($asignacionesAgentes, $asignaciones ['Sugerencias']);

        if(count($asignacionesAreas)>0)
            $asignaciones ['Áreas'] = $asignacionesAreas;
        if(count($asignacionesAgentes)>0)
            $asignaciones ['Agentes'] = $asignacionesAgentes;
        

        

        //return var_dump($asignaciones);
        

        
        $estados = Estadoticket::find()->all();


        if ($model->load(Yii::$app->request->post()) && $modelasignacion->load(Yii::$app->request->post()) && $modelajuntos->load(Yii::$app->request->post())) {
            //return var_dump($model);
            $images = UploadedFile::getInstances($modelajuntos, 'image');

            //return var_dump(Yii::$app->request->post());

            if($modelasignacion->agente<0){
                $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_NOREQ;
                $modelasignacion->areaticket = abs($modelasignacion->agente);
                $modelasignacion->agente =null;
            }else{
                $modelasignacion->agente = abs($modelasignacion->agente);
                $modelasignacion->areaticket =null;
            }

            $modelasignacion->anteriorasignacion = $ultimaasignacion->id;

            $modelasignacion->save();

            $model->asignacionticket = $modelasignacion->id;
            $model->save();

            $modelasignacion->detalleticket =$model->id;
            $modelasignacion->save();

            $ticketModel->estadoticket = $model->estadoticket;
            $ticketModel->asignacionticket = $model->asignacionticket;
            $ticketModel->save();

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosX = new Adjuntoticket();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosX->nombre = $image->name;
                    $modelajuntosX->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosX->detalleticket = $model->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/tickets/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosX->url;
                    $image->saveAs($path);
                    $modelajuntosX->save();
                }
            }

            return $this->redirect(['/ticket/ticket/view', 'id' => $ticketModel->id]);
        }

        //return var_dump($model);

        return $this->renderAjax('create', [
            'model' => $model,
            'ticketModel' => $ticketModel,
            'modelasignacion' => $modelasignacion,
            'asignaciones' => $asignaciones,
            'modelajuntos' => $modelajuntos,
            'estados' => $estados,
        ]);
    }

    /**
     * Updates an existing Detalleticket model.
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
     * Deletes an existing Detalleticket model.
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
     * Finds the Detalleticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
