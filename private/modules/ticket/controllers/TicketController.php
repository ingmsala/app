<?php

namespace app\modules\ticket\controllers;

use app\models\Agente;
use app\modules\ticket\models\Adjuntoticket;
use app\modules\ticket\models\AdjuntoticketSearch;
use app\modules\ticket\models\Areaticket;
use app\modules\ticket\models\Asignacionticket;
use app\modules\ticket\models\Detalleticket;
use app\modules\ticket\models\DetalleticketSearch;
use app\modules\ticket\models\Prioridadticket;
use Yii;
use app\modules\ticket\models\Ticket;
use app\modules\ticket\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $adjuntos = Adjuntoticket::find()->where(['ticket' => $id])->all();
        
        $primeraAsignacion = Asignacionticket::find()
                        ->where(['ticket' => $id])
                        ->min('id');
        $primeraAsignacion = Asignacionticket::findOne($primeraAsignacion);

        $searchModel = new DetalleticketSearch();
        $dataProvider = $searchModel->porTicket($id);
        $modelDetalles = Detalleticket::find()->where(['ticket' => $id])->all();


        return $this->render('view', [
            'model' => $this->findModel($id),
            'adjuntos' => $adjuntos,
            'dataProvider' => $dataProvider,
            'modelDetalles' => $modelDetalles,
            'primeraAsignacion' => $primeraAsignacion,
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticket();
        $modelasignacion = new Asignacionticket();
        $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_REQ;
        $modelajuntos = new Adjuntoticket();
        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model->fecha = date('Y-m-d');
        $model->hora = date('H:i');
        
        $creador = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $creadores = Agente::find()/*->where(['mail' => Yii::$app->user->identity->username])*/->all();
        $model->estadoticket = 1;
        $model->agente = $creador->id;
        $model->prioridadticket = 1;

        $prioridades = Prioridadticket::find()->all();

        $areas = Areaticket::find()->all();
        $agentes = Agente::find()->all();
        $asignaciones = [];
        $asignaciones ['Áreas']=ArrayHelper::map($areas,function($model){return -$model->id;}, 'nombre');
        $asignaciones ['Agentes'] = ArrayHelper::map($agentes,function($model){return $model->id;}, function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );

        //return var_dump($asignaciones);


        
        if ($model->load(Yii::$app->request->post()) && $modelasignacion->load(Yii::$app->request->post()) && $modelajuntos->load(Yii::$app->request->post())) {
            $images = UploadedFile::getInstances($modelajuntos, 'image');
            
            //return var_dump($images);

            

            if($modelasignacion->agente<0){
                $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_NOREQ;
                $modelasignacion->areaticket = abs($modelasignacion->agente);
                $modelasignacion->agente =null;
            }else{
                $modelasignacion->agente = abs($modelasignacion->agente);
                $modelasignacion->areaticket =null;
            }

            $modelasignacion->save();
            $model->asignacionticket = $modelasignacion->id;
            $model->save();
            $modelasignacion->ticket =$model->id;
            $modelasignacion->save();

            if (!is_null($images)) {
                foreach ($images as $image) {
                    $modelajuntosX = new Adjuntoticket();
                    $arr = [];
                    $arr = explode(".", $image->name);
                    $ext = end($arr);
                    $modelajuntosX->nombre = $image->name;
                    $modelajuntosX->url = Yii::$app->security->generateRandomString().".{$ext}";
                    $modelajuntosX->ticket = $model->id;
                    Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/tickets/';
                    $path = Yii::$app->params['uploadPath'] . $modelajuntosX->url;
                    $image->saveAs($path);
                    $modelajuntosX->save();
                    
                }
                
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
            
        }

        return $this->render('create', [
            'model' => $model,
            'modelasignacion' => $modelasignacion,
            'creadores' => $creadores,
            'prioridades' => $prioridades,
            'asignaciones' => $asignaciones,
            'modelajuntos' => $modelajuntos,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelasignacion = Asignacionticket::findOne($model->asignacionticket);
        $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_REQ;
        $modelajuntos = new Adjuntoticket();

        $searchModelAdjuntos = new AdjuntoticketSearch();
        $dataProviderAdjuntos = $searchModelAdjuntos->porTicket($model->id);

        
        $areas = Areaticket::find()->all();
        $agentes = Agente::find()->orderBy('apellido, nombre')->all();
        $creadores = Agente::find()/*->where(['mail' => Yii::$app->user->identity->username])*/->all();
        $prioridades = Prioridadticket::find()->all();

        $asignaciones = [];

        $asignaciones ['Áreas']=ArrayHelper::map($areas,function($model){return -$model->id;}, 'nombre');
        $asignaciones ['Agentes'] = ArrayHelper::map($agentes,function($model){return $model->id;}, function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );

        if($model->asignacionticket0->agente == null){
            $modelasignacion->agente = -$model->asignacionticket0->areaticket;
        }else{
            $modelasignacion->agente = $model->asignacionticket0->agente;
        }

        if ($model->load(Yii::$app->request->post()) && $modelasignacion->load(Yii::$app->request->post()) && $modelajuntos->load(Yii::$app->request->post())) {

            //return var_dump($modelasignacion);
            if($modelasignacion->agente<0){
                $modelasignacion->scenario = $modelasignacion::SCENARIO_AGENTE_NOREQ;
                $modelasignacion->areaticket = abs($modelasignacion->agente);
                $modelasignacion->agente =null;
            }else{
                $modelasignacion->agente = abs($modelasignacion->agente);
                $modelasignacion->areaticket =null;
            }

            $modelasignacion->save();
            $model->asignacionticket = $modelasignacion->id;
            $model->save();
            
            

            $image = UploadedFile::getInstance($modelajuntos, 'image');
            if (!is_null($image)) {
                $arr = explode(".", $image->name);
                $ext = end($arr);
                $modelajuntos->nombre = $image->name;
                $modelajuntos->url = Yii::$app->security->generateRandomString().".{$ext}";
                $modelajuntos->ticket = $model->id;
                Yii::$app->params['uploadPath'] = Yii::getAlias('@webroot') . '/assets/images/tickets/';
                $path = Yii::$app->params['uploadPath'] . $modelajuntos->url;
                $image->saveAs($path);
                $modelajuntos->save();
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelasignacion' => $modelasignacion,
            'creadores' => $creadores,
            'prioridades' => $prioridades,
            'asignaciones' => $asignaciones,
            'modelajuntos' => $modelajuntos,
            'searchModelAdjuntos' => $searchModelAdjuntos,
            'dataProviderAdjuntos' => $dataProviderAdjuntos,
        ]);
    }

    /**
     * Deletes an existing Ticket model.
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
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
