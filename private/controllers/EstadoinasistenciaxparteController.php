<?php

namespace app\controllers;

use Yii;
use app\models\Estadoinasistenciaxparte;
use app\models\Falta;
use app\models\EstadoinasistenciaxparteSearch;
use app\models\Detalleparte;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

use yii\widgets\ActiveForm; // Ajaxvalidation

use yii\web\Response; // Ajaxvalidation

/**
 * EstadoinasistenciaxparteController implements the CRUD actions for Estadoinasistenciaxparte model.
 */
class EstadoinasistenciaxparteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'justificar', 'nuevoestado'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA,  Globales::US_SACADEMICA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['justificar', 'nuevoestado'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_SACADEMICA]);
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
     * Lists all Estadoinasistenciaxparte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstadoinasistenciaxparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estadoinasistenciaxparte model.
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
     * Creates a new Estadoinasistenciaxparte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($detalle=null, $detalleparte=null, $estadoinasistencia=null)
    {
        
       
        $detallepartex = Detalleparte::findOne($detalleparte);

        $model = new Estadoinasistenciaxparte();

        $model->scenario = $model::SCENARIO_COMISONREG;
        
        $faltas = Falta::find()
                    ->where(['<=','id',Globales::FALTA_COMISION])
                    ->andWhere(['<>','id',$detallepartex->falta])
                    ->all();

                    
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }


        if ($model->load(Yii::$app->request->post())) {

           // $model->detalle = $detalle;
            $model->detalleparte = $detalleparte;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d H:i:s");
            $model->estadoinasistencia = $estadoinasistencia;

            if($model->save()){
               
                $detallepartex->falta = $model->falta;
                $model->estadoinasistencia = $estadoinasistencia;
                $detallepartex->estadoinasistencia = $model->estadoinasistencia;
                $detallepartex->save();

                if($estadoinasistencia==3)
                    return $this->redirect(['parte/controlregencia']);
                elseif($estadoinasistencia==7){
                    return $this->redirect(['parte/controlacademica']);
                }else{
                    return $this->redirect(['parte/controlsecretaria']);
                }
                //return $this->redirect(['parte/controlregencia']);
            }
        }
        
        return $this->renderAjax('create', [
                    'model' => $model,
                    'faltas' => $faltas,
                ]);
         

        
    }

    /**
     * Updates an existing Estadoinasistenciaxparte model.
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
     * Deletes an existing Estadoinasistenciaxparte model.
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
     * Finds the Estadoinasistenciaxparte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Estadoinasistenciaxparte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estadoinasistenciaxparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionNuevoestado($estadoinasistencia, $detalleparte){

        $eixp = Estadoinasistenciaxparte::findOne(Estadoinasistenciaxparte::find()->where(['detalleparte' => $detalleparte])->max('id'));
        $model = new Estadoinasistenciaxparte;
        $model->detalle = $eixp->detalle;
        $model->estadoinasistencia = $estadoinasistencia;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model->fecha = date("Y-m-d H:i:s");
        $model->detalleparte = $detalleparte;
        $dp = Detalleparte::findOne($detalleparte);
        
        $dp->estadoinasistencia = $estadoinasistencia;
        $dp->save();
        $model->falta = $dp->falta;
        if ($model->save()){
            if($estadoinasistencia==Globales::ESTADOINASIST_REGRAT)
                return $this->redirect(['parte/controlregencia']);
            elseif($estadoinasistencia==6){
                return $this->redirect(['parte/controlacademica']);
            }else{
                return $this->redirect(['parte/controlsecretaria']);
            }
        
            
        }else{
            return false;
        }
    }

    public function actionJustificar($detalle=null, $detalleparte=null, $estadoinasistencia=null)
    {
        $detallepartex = Detalleparte::findOne($detalleparte);

        $model = new Estadoinasistenciaxparte();
        $faltas = Falta::find()
                    ->where(['<=','id',Globales::FALTA_COMISION])
                    ->andWhere(['<>','id',$detallepartex->falta])
                    ->all();

        if ($model->load(Yii::$app->request->post())) {

           // $model->detalle = $detalle;
            $model->detalleparte = $detalleparte;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d H:i:s");
            $model->estadoinasistencia = $estadoinasistencia;

            if($model->save()){
               
                $detallepartex->falta = $model->falta;
                $model->estadoinasistencia = $estadoinasistencia;
                $detallepartex->save();
                return $this->redirect(['parte/controlsecretaria']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'faltas' => $faltas,
        ]);
    }
}
