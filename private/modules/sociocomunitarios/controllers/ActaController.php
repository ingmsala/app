<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\ActaSearch;
use app\modules\curriculares\models\Admisionoptativa;
use app\modules\curriculares\models\Admisionsociocom;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Detalleacta;
use app\modules\curriculares\models\DetalleactaSearch;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Escalanota;
use app\modules\curriculares\models\Libroacta;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\MatriculaSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ActaController implements the CRUD actions for Acta model.
 */
class ActaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'actas', 'view', 'create', 'update','cerraracta', 'delete'],
                'rules' => [
                    [
                        'actions' => ['actas'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_PSC, Globales::US_PRECEPTORIA]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    //$acta = $this->findModel(Yii::$app->request->queryParams['id']);
                                    /*if($acta == null){
                                        return true;
                                    }*/
                                    /*$agente = Agente::find()->where(['legajo' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $acta->comision])
                                                    ->andWhere(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }*/
                                    return true;
                                }
                                return false;
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_PSC, Globales::US_PRECEPTORIA])){
                                    return true;
                                }
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    $acta = $this->findModel(Yii::$app->request->queryParams['id']);
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $acta->comision])
                                                    ->andWhere(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }
                                }
                                return false;
                                
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],


                    [
                        'actions' => ['cerraracta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    $acta = $this->findModel(Yii::$app->request->queryParams['acta']);
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $acta->comision])
                                                    ->andWhere(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }
                                }
                                return false;
                                
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
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]))
                                    return true;
                                elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
                                    $com = Comision::findOne(Yii::$app->request->queryParams['Matricula']['comision']);
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                    ->where(['comision' => $com])
                                                    ->andWhere(['agente' => $agente->id])
                                                    ->all());
                                    if($cant>0){
                                        return true;
                                    }
                                }
                                return false;
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Acta models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $param = Yii::$app->request->queryParams;
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;

        
        
        $aniolectivos = Aniolectivo::find()->all();

        $comisiones = Matricula::find()->all();
        if($model->load(Yii::$app->request->post())){
            //return var_dump(Yii::$app->request->post()['Matricula']['comision']);
            $model->comision= Yii::$app->request->post()['Matricula']['comision'];
            $collapse = '';
            $libro = Libroacta::find()
                        ->where(['aniolectivo' =>  $model->aniolectivo])
                        ->andWhere(['estado' => 1])->one()->id;
            $comision = $model->comision;
        }else{
            $collapse = 'in';
            $libro = 0;
            $comision = 0;
        }

        $searchModel = new ActaSearch();
        $dataProvider = $searchModel->search($comision);

        /*if(isset($param['Matricula']['aniolectivo']))
            $model->aniolectivo = $param['Matricula']['aniolectivo'];
        if(isset($param['Matricula']['comision']))
            $model->comision = $param['Matricula']['comision'];*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aniolectivos' => $aniolectivos,
            'libro' => $libro,
            'comision' => $model->comision,

            'param' => Yii::$app->request->post(),
            'model' => $model,
            'comisiones' => $comisiones,
            'collapse' => $collapse,
        ]);
    }

    public function actionActas()
    {
        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $comision = Comision::findOne($com);
        
            $model = new Matricula();
            $model->scenario = $model::SCENARIO_SEARCHINDEX;
            $model->comision = $com;
            $model->aniolectivo = $comision->espaciocurricular0->aniolectivo;
            
            
            /*$libro = Libroacta::find()
                        ->where(['aniolectivo' =>  $model->aniolectivo])
                        ->andWhere(['estado' => 1])->one()->id;*/
            
            $searchModel = new ActaSearch();
            $dataProvider = $searchModel->search($com);

        
            return $this->render('actas', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                
                //'libro' => $libro,
                'comision' => $model->comision,
                'model' => $model,
                
            ]);

        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
                return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Displays a single Acta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
        $comision = $this->findModel($id)->comision;

        $searchModelDetacta = new DetalleactaSearch();
        $dataProviderDetacta = $searchModelDetacta->alumnosXacta($id);

        $detallesx = Detalleacta::find()->joinWith(['matricula0', 'matricula0.alumno0'])->where(['acta' => $id])->orderBy('alumno.apellido, alumno.nombre')->all();

        $array = [];

        foreach ($detallesx as $detalleactax) {
            $array[] = $detalleactax->matricula;
        }
        
        
        $dataProvider = $searchModel->alumnosxcomisionSinActa($comision, $array);
        $cantsinacta = $dataProvider->getTotalCount();
        $cantenacta = $dataProviderDetacta->getTotalCount();

        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'dataProviderDetacta' => $dataProviderDetacta,
            'cantsinacta' => $cantsinacta,
            'cantenacta' => $cantenacta,
        ]);
    }

    /**
     * Creates a new Acta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Acta();

        $model->scenario = Acta::SCENARIO_ABM;

        $escalas = Escalanota::find()->all();
        $model->comision = Yii::$app->request->get()['Matricula']['comision'];
        

        if ($model->load(Yii::$app->request->post())) {
            
            $libro = Libroacta::find()->where(['estado' => 1])->one();
            $model->libro =$libro->id;
            
            $cant = count(Acta::find()->where(['libro' => $libro->id])->all()) + 1;
            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
        
            
            $model->estadoacta = 1;
            
            
            $model->save();
            //$cant = $model->id;
            if($cant<10)
                $model->nombre = '0000'.$cant;
            elseif($cant<100)
                $model->nombre = '000'.$cant;
            elseif($cant<1000)
                $model->nombre = '00'.$cant;
            elseif($cant<10000)
                $model->nombre = '0'.$cant;
            else
                $model->nombre = $cant;
            
            $model->save();

                
                

            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'escalas' => $escalas,
        ]);
    }

    /**
     * Updates an existing Acta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);
        $escalas = Escalanota::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'escalas' => $escalas,
        ]);
    }

    public function actionCerraracta($acta)
    {
        $this->layout = 'main';
        $model = $this->findModel($acta);
        $da = Detalleacta::find()
                ->where(['acta' => $acta])
                ->andWhere(['is', 'detalleescala', null])
                ->all();

        if(count($da)>0){
            Yii::$app->session->setFlash('danger', "Faltan cargar notas en el acta, no puede cerrarse.");
            return $this->redirect(['detalleacta/cerraracta', 'acta_id' => $acta]);
        }
        
        $da2 = Detalleacta::find()
                ->where(['acta' => $acta])
                ->all();

        $c = 0;
        
        foreach ($da2 as $detalleacta) {
            $rep = 1;
            $aniolectivo = $model->libro0->aniolectivo+1;
            $matricula = Matricula::findOne($detalleacta->matricula);
            if($detalleacta->detalleescala0->condicionnota == 1){
                $estado = 3;
            }elseif ($detalleacta->detalleescala0->condicionnota == 2) {
                $estado = 1;
                $rep = 0;
            }elseif ($detalleacta->detalleescala0->condicionnota == 3) {
                $estado = 2;
                $rep = 0;
            }
            $matricula->estadomatricula = $estado;
            $matricula->save();
            $c++;
            for ($i=1; $i >= $rep; $i--) { 
                $admision = new Admisionsociocom();
                $admision->alumno = $matricula->alumno;
                $admision->curso = $matricula->comision0->espaciocurricular0->curso+$i;
                $admision->aniolectivo = $aniolectivo;
                $admision->save();
            }
            
        }

        $model->estadoacta = 2;
        $model->user = Yii::$app->user->identity->id;
        $model->save();
        
        
        Yii::$app->session->setFlash('success', "Se cerró el acta correctamente con {$c} nota/s");
        return $this->redirect(['detalleacta/cerraracta', 'acta_id' => $model->id]);
        
    }

    /**
     * Deletes an existing Acta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Acta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Acta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
