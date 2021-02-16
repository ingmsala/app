<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\AgenteSearch;
use app\models\Nombramiento;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\Caso;
use app\modules\edh\models\ParticipantereunionSearch;
use Yii;
use app\modules\edh\models\Reunionedh;
use app\modules\edh\models\ReunionedhSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReunionedhController implements the CRUD actions for Reunionedh model.
 */
class ReunionedhController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = Caso::findOne(Yii::$app->request->queryParams['caso']);

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                

                                $jefe = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

                                if ($caso->jefe == $jefe->id)
                                     return true;
                            }

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){

                                $prece = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                        
                                if ($caso->preceptor == $prece->id)
                                     return true;
                            
                            }

                            return false;
                        }

                    ],
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = $this->findModel(Yii::$app->request->queryParams['id'])->caso0;

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                

                                $jefe = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

                                if ($caso->jefe == $jefe->id)
                                     return true;
                            }

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){

                                $prece = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                        
                                if ($caso->preceptor == $prece->id)
                                     return true;
                            
                            }

                            return false;
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
     * Lists all Reunionedh models.
     * @return mixed
     */
    public function actionIndex($caso)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = Caso::findOne($caso);

        if(!in_array(3, array_column($model->solicitudedhs, 'estadosolicitud'))){
            Yii::$app->session->setFlash('danger', 'No se puede gestionar Reuniones, ya que no existe ninguna solicitud en estado <b>"Aceptada"</b>');
            return $this->redirect(['caso/view', 'id' => $model->id]);
        }


        $searchModel = new ReunionedhSearch();
        $dataProvider = $searchModel->porCaso($caso);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }



    /**
     * Displays a single Reunionedh model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        $searchModelParticipantes = new ParticipantereunionSearch();
        
        $dataProviderParticipantes = $searchModelParticipantes->porReunion($model->id);

        
        try {
            $desdeexplode = explode("-",$model->fecha);
            $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
            $model->fecha = $newdatedesde;
        } catch (\Throwable $th) {
            
        }
        

        if ($model->load(Yii::$app->request->post())) {

            //return var_dump(Yii::$app->request->post());
            if($model->caso0->estadocaso == 2){
                Yii::$app->session->setFlash('danger', '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_REGENCIA])){
                Yii::$app->session->setFlash('danger', '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No tiene los permisos para realizar la acción');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->save();

            //Yii::$app->session->setFlash('success2', 'Se guardó correctamente');
            Yii::$app->session->set('success3', "Se <b>actualizó</b> correctamente la reunión");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
            'searchModelParticipantes' => $searchModelParticipantes,
            'dataProviderParticipantes' => $dataProviderParticipantes,
           
        ]);
    }

    /**
     * Creates a new Reunionedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($caso)
    {
        $model = new Reunionedh();
        $model->caso = $caso;
        $casoX = Caso::findOne($caso);
        if($casoX->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->save();
            $actuacion = new Actuacionedh();
            $actuacion = $actuacion->nuevaActuacion($model->caso, 3, 'Se crea reunión: '.$model->tematica, 1);
            Yii::$app->session->setFlash('success', 'Se creó la reunión correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reunionedh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->caso0->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reunionedh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $caso = $model->caso;
        if($model->caso0->estadocaso == 2){
            Yii::$app->session->setFlash('danger', '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>');
            //return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
            return $this->redirect(['view', 'id' => $id]);
        }
        
        try {
            $model->delete();
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('danger', 'No puede eliminar una reunión que posee participantes');
        }
        

        return $this->redirect(['index', 'caso' => $caso]);
    }

    /**
     * Finds the Reunionedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reunionedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reunionedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
