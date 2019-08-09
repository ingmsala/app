<?php

namespace app\controllers;

use Yii;
use app\models\Parte;
use app\models\ParteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Detalleparte;
use app\models\Preceptoria;
use app\models\Docente;
use app\models\Estadoinasistencia;
use app\models\Estadoinasistenciaxparte;
use app\models\DetalleparteSearch;
use app\models\NovedadesparteSearch;
use app\models\Avisoinasistencia;
use app\models\AvisoinasistenciaSearch;
use yii\filters\AccessControl;
use app\config\Globales;


/**
 * ParteController implements the CRUD actions for Parte model.
 */
class ParteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'controlregencia', 'controlsecretaria', 'procesarmarcadosreg', 'controlacademica'],
                'rules' => [
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SACADEMICA])){
                                        return true;
                                    }

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                        $parte = $this->findModel(Yii::$app->request->queryParams['id']);
                                        
                                        if ($parte->preceptoria0->nombre == Yii::$app->user->identity->username)
                                             return true;
                                    }

                                    return false;

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],

                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_CONSULTA, Globales::US_SACADEMICA]);
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['delete', 'update'],   
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
                        'actions' => ['controlregencia'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['controlacademica'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SACADEMICA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['procesarmarcadosreg'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['controlsecretaria'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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
     * Lists all Parte models.
     * @return mixed
     */
    public function actionIndex($nav = false)
    {
        $param = Yii::$app->request->queryParams;
        $searchModel = new ParteSearch();
        $dataProvider = $searchModel->search($param);



        $model = new Parte();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;

        if(isset($param['Parte']['fecha']))
            $model->fecha = $param['Parte']['fecha'];
        if(isset($param['Parte']['mes']))
            $model->mes = $param['Parte']['mes'];
        if(isset($param['Parte']['preceptoria']))
            $model->preceptoria = $param['Parte']['preceptoria'];

        return $this->render('index', [
            'model' => $model,
            'param' => Yii::$app->request->queryParams,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'preceptorias' => Preceptoria::find()->all()
        ]);
    }

    /**
     * Displays a single Parte model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerxparte($id);
        $dataProviderOtras = $searchModel->otrasausencias($id, $model->fecha);

        $searchModelnovedades = new NovedadesparteSearch();
        $dataProvidernovedades = $searchModelnovedades->novedadesxparte($id);

        $searchModelavisosinasistencias = new AvisoinasistenciaSearch();
        $dataProvideravisosinasistencias = $searchModelavisosinasistencias->providerFromParte($model->fecha);
        

        return $this->render('view', [
            'model' => $model,
            'modeldetalle' => Detalleparte::find()->where([
                'parte' => $id,
                
            ])->one(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderOtras' => $dataProviderOtras,

            'searchModelnovedades' => $searchModelnovedades,
            'dataProvidernovedades' => $dataProvidernovedades,
            'searchModelavisosinasistencias' => $searchModelavisosinasistencias,
            'dataProvideravisosinasistencias' => $dataProvideravisosinasistencias,
        ]);
    }

    /**
     * Creates a new Parte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
            if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA])){
                $precepx=Preceptoria::find()
                    ->orderBy('nombre')->all();
            }else{
                $precepx=Preceptoria::find()
                    ->where(['nombre' => Yii::$app->user->identity->username])
                    ->orderBy('nombre')->all();
            }
            

        $model = new Parte();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->fecha = Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd');

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
                'precepx' => $precepx,
            ]);
        return $this->render('create', [
                'model' => $model,
                'precepx' => $precepx,
            ]);
        

        
    }

    /**
     * Updates an existing Parte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset ($_REQUEST['precepx'])) {
            $precepx = $_REQUEST['precepx'] ;
            $precepx=Preceptoria::find()
                ->where(['nombre' => $precepx])
                ->orderBy('nombre')->all();
        
        }else{
                
                $precepx=Preceptoria::find()->all();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'precepx' => $precepx,
        ]);
    }

    /**
     * Deletes an existing Parte model.
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

    public function actionControlregencia(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $param = Yii::$app->request->queryParams;



        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_CONTROLREGENCIA;

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['docente']))
            $model->docente = $param['Detalleparte']['docente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];


        return $this->render('controlregencia', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'param' => Yii::$app->request->queryParams,
            'docentes' => Docente::find()->orderBy('apellido, nombre')->all(),
            'estadoinasistencia' => Estadoinasistencia::find()->where(['<=','id',Globales::ESTADOINASIST_REGREC])->all(),
        ]);
    }

    public function actionControlacademica(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $param = Yii::$app->request->queryParams;



        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_CONTROLREGENCIA;

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['docente']))
            $model->docente = $param['Detalleparte']['docente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];


        return $this->render('controlacademica', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'param' => Yii::$app->request->queryParams,
            'docentes' => Docente::find()->orderBy('apellido, nombre')->all(),
            'estadoinasistencia' => Estadoinasistencia::find()->where(['<=','id',Globales::ESTADOINASIST_REGREC])->all(),
        ]);
    }

    public function actionControlsecretaria(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $param = Yii::$app->request->queryParams;



        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_CONTROLREGENCIA;

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['docente']))
            $model->docente = $param['Detalleparte']['docente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];

        return $this->render('controlsecretaria', [
            
            'dataProvider' => $dataProvider,
            'model' => $model,
            'searchModel' => $searchModel,
            
            'param' => Yii::$app->request->queryParams,
            'docentes' => Docente::find()->orderBy('apellido, nombre')->all(),
            'estadoinasistencia' => Estadoinasistencia::find()->where(['<=','id',Globales::ESTADOINASIST_SECJUS])->all(),
        ]);
    }

    public function actionProcesarmarcadosreg(){
        $param = Yii::$app->request->post();
        //return $param['id'][1];
        $c=0;
        foreach ($param['id'] as $detalleseleccionado) {
            $c=$c+1;
            $model = new Estadoinasistenciaxparte;
            $model->detalle = null;
            $model->estadoinasistencia = $param['or'][0];
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d H:i:s");
            $model->detalleparte = $detalleseleccionado;
            $dp = Detalleparte::findOne($detalleseleccionado);
            
            $dp->estadoinasistencia = $param['or'][0];
            $dp->save();
            $model->falta = $dp->falta;
            $model->save();
        }
        
        return $c;
        
        
        
    }    

    public function actionProcesarmarcadosregrec(){
        $param = Yii::$app->request->post();
        //return $param['id'][1];
        
        foreach ($param['id'] as $detalleseleccionado) {
            
            $model = new Estadoinasistenciaxparte;
            $model->detalle = null;
            $model->estadoinasistencia = Globales::ESTADOINASIST_REGREC;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fecha = date("Y-m-d H:i:s");
            $model->detalleparte = $detalleseleccionado;
            $dp = Detalleparte::findOne($detalleseleccionado);
            
            $dp->estadoinasistencia = Globales::ESTADOINASIST_REGREC;
            ($dp->falta == Globales::FALTA_COMISION) ? $dp->falta = Globales::FALTA_FALTA : $dp->falta = Globales::FALTA_COMISION;
            $dp->save();
            $model->falta = $dp->falta;
            $model->save();
        }
        
        return 'ok';
        
        
        
    }
    /**
     * Finds the Parte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
