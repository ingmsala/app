<?php

namespace app\controllers;

use Yii;
use app\models\Parte;
use app\models\ParteSearch;
use app\models\Tipoparte;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Detalleparte;
use app\models\Preceptoria;
use app\models\Agente;
use app\models\Estadoinasistencia;
use app\models\Estadoinasistenciaxparte;
use app\models\DetalleparteSearch;
use app\models\NovedadesparteSearch;
use app\models\Avisoinasistencia;
use app\models\AvisoinasistenciaSearch;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Nombramiento;
use app\models\Rolexuser;
use app\modules\curriculares\models\Aniolectivo;


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

                                        $role = Rolexuser::find()
                                                    ->where(['user' => Yii::$app->user->identity->id])
                                                    ->andWhere(['role' => Globales::US_PRECEPTORIA])
                                                    ->one();
                                        
                                        
                                        if ($parte->preceptoria0->nombre == $role->subrole)
                                             return true;
                                    }

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){
                                        $parte = $this->findModel(Yii::$app->request->queryParams['id']);

                                        $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                        $nom = Nombramiento::find()
                                                    ->where(['agente' => $doc->id])
                                                    ->andWhere(['<=', 'division', 53])
                                                    //->andWhere(['is not', 'division', 53])
                                                    ->all();
                                        
                                        foreach ($nom as $n) {
                                            if($n->division0->preceptoria0->nombre == $parte->preceptoria0->nombre){
                                                return true;
                                            }
                                        }
                                            return false;
                                        
                                        
                                        
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_CONSULTA, Globales::US_SACADEMICA, Globales::US_PRECEPTOR]);
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR]);
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
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            $this->layout = 'mainpersonal';
        }
        $param = Yii::$app->request->queryParams;
        $searchModel = new ParteSearch();
        $dataProvider = $searchModel->search($param);



        $model = new Parte();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;
        $years = Aniolectivo::find()->all();

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
            'preceptorias' => Preceptoria::find()->all(),
            'years' => $years,
        ]);
    }

    /**
     * Displays a single Parte model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $tab = 1)
    {
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            $this->layout = 'mainpersonal';
        }
        $model = $this->findModel($id);
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerxparte($id);
        $dataProviderOtras = $searchModel->otrasausencias($id, $model->fecha);

        $searchModelnovedades = new NovedadesparteSearch();
        $dataProvidernovedades = $searchModelnovedades->novedadesxparte($id);

        $searchModelnovedadesEdilicias = new NovedadesparteSearch();
        $dataProvidernovedadesEdilicias = $searchModelnovedadesEdilicias->novedadesEdiliciasActivas($id);

        $searchModelavisosinasistencias = new AvisoinasistenciaSearch();
        $dataProvideravisosinasistencias = $searchModelavisosinasistencias->providerFromParte($model->fecha);
        
        if($model->preceptoria != 8){
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

            'searchModelnovedadesEdilicias' => $searchModelnovedadesEdilicias,
            'dataProvidernovedadesEdilicias' => $dataProvidernovedadesEdilicias,

            'searchModelavisosinasistencias' => $searchModelavisosinasistencias,
            'dataProvideravisosinasistencias' => $dataProvideravisosinasistencias,
            
            'tab' => $tab,
        ]); 
        }else{
            return $this->render('/novedadesparte/_edilicias', [
            

            'searchModel' => $searchModelnovedades,
            'dataProvider' => $dataProvidernovedades,

            'searchModelnovedadesEdilicias' => $searchModelnovedadesEdilicias,
            'dataProvidernovedadesEdilicias' => $dataProvidernovedadesEdilicias,
            
            'model' => $model,

            
            ]); 
        }
        
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
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                $role = Rolexuser::find()
                            ->where(['user' => Yii::$app->user->identity->id])
                            ->andWhere(['role' => Globales::US_PRECEPTORIA])
                            ->one();
                                        
                $precepx=Preceptoria::find()
                    ->where(['nombre' => $role->subrole])
                    ->orderBy('nombre')->all();
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                $this->layout = 'mainpersonal';
                $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                $nom = Nombramiento::find()
                            ->where(['agente' => $doc->id])
                            ->andWhere(['<=', 'division', 53])
                            //->andWhere(['is not', 'division', 53])
                            ->all();
                $array = [];
                foreach ($nom as $n) {
                    $array [] = $n->division0->preceptoria0->nombre;
                }
                $precepx=Preceptoria::find()
                            ->where(['in', 'nombre', $array])
                            ->all();
                                        
            }
            

        $model = new Parte();
        $tiposparte = Tipoparte::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
            //$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd');

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
                'precepx' => $precepx,
                'tiposparte' => $tiposparte,
            ]);
        return $this->render('create', [
                'model' => $model,
                'precepx' => $precepx,
                'tiposparte' => $tiposparte,
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
        
        //return var_dump($newdatedesde);
        $tiposparte = Tipoparte::find()->all();
        if (isset ($_REQUEST['precepx'])) {
            $precepx = $_REQUEST['precepx'] ;
            $precepx=Preceptoria::find()
                ->where(['nombre' => $precepx])
                ->orderBy('nombre')->all();
        
        }else{
                
                $precepx=Preceptoria::find()->all();
        }
        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode2 = explode("/",$model->fecha);
            
            $newdatedesde2 = date("Y-m-d", mktime(0, 0, 0, $desdeexplode2[1], $desdeexplode2[0], $desdeexplode2[2]));
            $model->fecha = $newdatedesde2;
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $desdeexplode = explode("-",$model->fecha);
        $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
        $model->fecha = $newdatedesde;

        return $this->render('update', [
            'model' => $model,
            'precepx' => $precepx,
            'tiposparte' => $tiposparte,
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
        $years = Aniolectivo::find()->all();

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['agente']))
            $model->agente = $param['Detalleparte']['agente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];


        return $this->render('controlregencia', [
            'model' => $model,
            'searchModel' => $searchModel,
            'years' => $years,
            'dataProvider' => $dataProvider,
            'param' => Yii::$app->request->queryParams,
            'docentes' => Agente::find()->orderBy('apellido, nombre')->all(),
            'estadoinasistencia' => Estadoinasistencia::find()->where(['<=','id',Globales::ESTADOINASIST_REGREC])->all(),
        ]);
    }

    public function actionControlacademica(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $param = Yii::$app->request->queryParams;



        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_CONTROLREGENCIA;
        $years = Aniolectivo::find()->all();

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['agente']))
            $model->agente = $param['Detalleparte']['agente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];


        return $this->render('controlacademica', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'years' => $years,
            'param' => Yii::$app->request->queryParams,
            'docentes' => Agente::find()->orderBy('apellido, nombre')->all(),
            'estadoinasistencia' => Estadoinasistencia::find()->where(['<=','id',Globales::ESTADOINASIST_REGREC])->all(),
        ]);
    }

    public function actionControlsecretaria(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $param = Yii::$app->request->queryParams;



        $model = new Detalleparte();
        $model->scenario = $model::SCENARIO_CONTROLREGENCIA;
        $years = Aniolectivo::find()->all();

        if(isset($param['Detalleparte']['anio']))
            $model->anio = $param['Detalleparte']['anio'];
        if(isset($param['Detalleparte']['mes']))
            $model->mes = $param['Detalleparte']['mes'];
        if(isset($param['Detalleparte']['agente']))
            $model->agente = $param['Detalleparte']['agente'];
        if(isset($param['Detalleparte']['estadoinasistencia']))
            $model->estadoinasistencia = $param['Detalleparte']['estadoinasistencia'];

        return $this->render('controlsecretaria', [
            
            'dataProvider' => $dataProvider,
            'model' => $model,
            'searchModel' => $searchModel,
            'years' => $years,
            
            'param' => Yii::$app->request->queryParams,
            'docentes' => Agente::find()->orderBy('apellido, nombre')->all(),
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
