<?php

namespace app\controllers;

use Yii;
use app\models\Novedadesparte;
use app\models\Tiponovedad;
use app\models\NotificacionSearch;
use app\models\Estadonovedad;
use app\models\Estadoxnovedad;
use app\models\Parte;
use app\models\Docente;
use app\models\NovedadesparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * NovedadesparteController implements the CRUD actions for Novedadesparte model.
 */
class NovedadesparteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'panelnovedades', 'nuevoestado'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_PRECEPTORIA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['nuevoestado'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_NOVEDADES]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['panelnovedades'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SACADEMICA, Globales::US_NOVEDADES]);
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
     * Lists all Novedadesparte models.
     * @return mixed
     */
    public function actionIndex($parte)
    {
        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesxparte($parte);
        $model = Parte::findOne($parte);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Novedadesparte model.
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
     * Creates a new Novedadesparte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parte)
    {
        $model = new Novedadesparte();
        $modelexn = new Estadoxnovedad();
        
        $model->parte = $parte;

        $tiponovedades = Tiponovedad::find()->all();
        $preceptores = Docente::find()
                        ->orderBy('apellido, nombre')
                        ->all();


        if ($model->load(Yii::$app->request->post())) {

            if ($model->tiponovedad != 1 && $model->tiponovedad != 5 && $model->tiponovedad != 6){
                $model->docente = null;
                if ($model->tiponovedad == 2 || $model->tiponovedad == 3){
                    $text = ' - N° de Aula o espacio: '.Yii::$app->request->post()["aulaoespacio"];
                    $text .= ' - Banco: '.Yii::$app->request->post()["banco"];
                    $model->descripcion = $text.' - '.$model->descripcion;

                    $novs = new NotificacionSearch(); 
                    $nov = $novs::providerXuserEspecifico(43);
                    $nov->cantidad = $nov->cantidad + 1;
                    $nov->save();
                }
            }

            if (in_array($model->tiponovedad, [1,4,5])){

                $novs = new NotificacionSearch(); 
                $nov = $novs::providerXuserEspecifico(3);
                $nov->cantidad = $nov->cantidad + 1;
                $nov->save();
            }

            if($model->save()){

                date_default_timezone_set('America/Argentina/Buenos_Aires');
                
                $modelexn->estadonovedad = 1;
                $modelexn->novedadesparte = $model->id;
                $modelexn->fecha = date("Y-m-d");
                if($modelexn->save()){

                    

                    Yii::$app->session->setFlash('success', "Se guardó correctamente la novedad.");
                    return $this->redirect(['/parte/view', 'id' => $model->parte]);
                }
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'tiponovedades' => $tiponovedades,
            'preceptores' => $preceptores,
        ]);
    }

    /**
     * Updates an existing Novedadesparte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tiponovedades = Tiponovedad::find()->all();
        $preceptores = Docente::find()
                        ->orderBy('apellido, nombre')
                        ->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->tiponovedad != 1 && $model->tiponovedad != 5 && $model->tiponovedad != 6){
                $model->docente = null;
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', "Se guardó correctamente la novedad.");
                return $this->redirect(['/parte/view', 'id' => $model->parte]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'tiponovedades' => $tiponovedades,
            'preceptores' => $preceptores,
        ]);
    }

    /**
     * Deletes an existing Novedadesparte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parte = $model->parte;
        $model->delete();
        Yii::$app->session->setFlash('success', "Se eliminó correctamente la novedad.");
        return $this->redirect(['/parte/view', 'id' => $parte]);
    }

    /**
     * Finds the Novedadesparte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Novedadesparte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Novedadesparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function tiponovedad(){
        if (Yii::$app->user->identity->role == Globales::US_SUPER)
            return 0;
        elseif(Yii::$app->user->identity->role == Globales::US_SECRETARIA)
            return 1;
        elseif(Yii::$app->user->identity->role == Globales::US_SACADEMICA)
            return 2;
        elseif(Yii::$app->user->identity->role == Globales::US_NOVEDADES)
            return 3;
        else
            return 4;
    }
    public function actionPanelnovedades()
    {

        $searchModel = new NovedadesparteSearch();
        $tiponovedad = $this->tiponovedad();
        $dataProvider = $searchModel->novedadesactivas(Globales::TIPO_NOV_X_USS[$tiponovedad]);
        /*$estados = Estadonovedad::find()
                    ->where(['<>', 'id', 1])
                    ->all();*/
        
        $novs = new NotificacionSearch(); 
        $nov = $novs::providerXuser();
        $nov->cantidad = 0;
        $nov->save();
        return $this->render('panelnovedades', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tiponovedad' => $tiponovedad,
            
        ]);
    }

    public function actionNuevoestado($id, $estado, $page)
    {
        $model = $this->findModel($id);
        if ($estado == 3)
            $model->activo = 2;
        $modelexn = new Estadoxnovedad();
        
        $model->save();

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d");
        /*$nuevafecha = strtotime ( '-50 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );*/
                
        $modelexn->estadonovedad = $estado;
        $modelexn->novedadesparte = $model->id;
        $modelexn->fecha = $fecha;

        $modelexn->save();
        
        if($model->tiponovedad == 2 || $model->tiponovedad == 3){
            $forzarpreceptoria = [9,10,11,6,7,8];
            $preceptoria = $model->parte0->preceptoria;
            
            $novs = new NotificacionSearch(); 
            $nov = $novs::providerXuserEspecifico($forzarpreceptoria[$preceptoria-1]);
            $nov->cantidad = $nov->cantidad + 1;
            $nov->save();
        }

        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesactivas(Globales::TIPO_NOV_X_USS[3]);
        
        return $this->redirect('index.php?r=novedadesparte/panelnovedades&page='.$page);
    }

    public function actionNotificacionesnuevas()
    {
        try{

            $ns = new NotificacionSearch(); 
            $nov = $ns::providerXuser();
            $cantnot = $nov->cantidad;
            $nov->cantidad = 0;
            $nov->save();
            
        }catch (Exception $e){
            $cantnot = 0;
            
        }

       
        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesSinNotificar($cantnot);
        $tiponovedad = $this->tiponovedad();
        
        
        return $this->render('notificationnews', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tiponovedad' => $tiponovedad,
        ]);
    }
}
