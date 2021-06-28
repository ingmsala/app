<?php

namespace app\controllers\panelacceso;

use Yii;
use app\models\Acceso;
use app\models\AccesoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Visitante;
use app\models\Area;
use app\models\Tarjeta;
use app\models\Cargo;
use yii\filters\AccessControl;
use app\config\Globales;



/**
 * AccesoController implements the CRUD actions for Acceso model.
 */
class AccesoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'buscarvisitante', 'egreso', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'buscarvisitante', 'egreso'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_INGRESO]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_INGRESO]);
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
     * Lists all Acceso models.
     * @return mixed
     */
    public function actionIndex($msg=null)
    {
        $searchModel = new AccesoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'msg' => $msg,
        ]);
    }

    /**
     * Displays a single Acceso model.
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
     * Creates a new Acceso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $dni, $apellidos, $nombres)
    {
        $model = new Acceso();
        $modelTarjeta = new Tarjeta();

        $areas=Area::find()->all();

        if ($model->load(Yii::$app->request->post()) && $modelTarjeta->load(Yii::$app->request->post())) {
            
            try{
            $model->tarjeta = Tarjeta::find()
                ->select('id')
                ->where(['codigo' => $modelTarjeta->codigo])->one()->id;
            }catch (\Exception $exception){
                $model->tarjeta = null;
            }
            if($this->isin($dni)){
                return $this->redirect(['index']);
            }else{    
                if ($model->save()){
                    Yii::$app->session->set('success', "Ingreso registrado correctamente");
                    return $this->redirect(['index']);
                }
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id,
            'dni' => $dni,
            'apellidos' => $apellidos,
            'nombres' => $nombres,
            'areas' => $areas,
            'modelTarjeta' => $modelTarjeta,
        ]);
    }

    private function isin($dni){
        $ing = Acceso::find()
            ->joinWith('visitante0 v')
            ->where(['v.dni' => $dni])
            ->andWhere(['fechaegreso' => null])->one();
        if ($ing == null)
            return false;
        else
            return true;
    }

    private function istarjetaasignada(){
        
    }

     public function actionBuscarvisitante()
    {
        $model = new Visitante();
        //$visx = $_REQUEST['visx'];
        

        if ($model->load(Yii::$app->request->post())) {

            $scannerdni = explode('@', $model->apellidos);


            if(count($scannerdni)>5){//escaneo
                $visitante = Visitante::find()
                        ->where(['dni' => $scannerdni[4]])->one();
            }else{
                $visitante = Visitante::find()
                            ->where(['dni' => $model->apellidos])->one();
            }

            if($visitante != null){//existe registrado
                return $this->redirect(['create', 
                    'id' => $visitante->id,
                    'dni' => $visitante->dni,
                    'apellidos' => $visitante->apellidos,
                    'nombres' => $visitante->nombres,
                    
                ]);
            }else{

                
                if(count($scannerdni)>5){
                    $model->dni = $scannerdni[4];
                    $model->apellidos = $scannerdni[1];
                    $model->nombres = $scannerdni[2];
                }else{
                    $model->dni = $model->apellidos;
                    $model->apellidos = null;
                    $model->nombres = null;
                }

                

                    return $this->redirect(['/panelacceso/visitante/create',
                        'dni' => $model->dni,
                        'apellidos' => $model->apellidos,
                        'nombres' => $model->nombres,
                    ]);
                

               
            }

        }

        return $this->renderAjax('buscarvisitante', [
            'model' => $model,
            
        ]);

        
    }

    /**
     * Updates an existing Acceso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEgreso()
    {
        
        $modelTarjeta = new Tarjeta();
        

        if ($modelTarjeta->load(Yii::$app->request->post())) {
            $model = $this->findModelxTarjeta($modelTarjeta->codigo);
            if($model!=null){

                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $model->fechaegreso = date("Y-m-d H:i:s");
                if ($model->save()){
                    Yii::$app->session->set('success', "Egreso registrado correctamente");
                    return $this->redirect(['index']);
                }
            }else{
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('egreso', [
            'modelTarjeta' => $modelTarjeta,
        ]);
    }

    /**
     * Deletes an existing Acceso model.
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
     * Finds the Acceso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acceso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Acceso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelxTarjeta($codigo)
    {
        $model = Acceso::find()
            ->joinWith(['tarjeta0'])
            ->where(['tarjeta.codigo' => $codigo])
            ->andWhere(['fechaegreso' => null])
            ->one();
        return $model;
        

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
