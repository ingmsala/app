<?php

namespace app\controllers;

use Yii;
use app\models\Nombramiento;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cargo;
use app\models\Docente;
use app\models\Revista;
use app\models\Division;
use app\models\Condicion;
use app\models\Extension;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * NombramientoController implements the CRUD actions for Nombramiento model.
 */
class NombramientoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'asignarsuplente'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete','asignarsuplente'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
     * Lists all Nombramiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->session->remove('urlorigen');
        $searchModel = new NombramientoSearch();
        $model = new Nombramiento();
        $param = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($param);
        $suplentes = Nombramiento::find()
                        ->where(['condicion' => Globales::COND_SUPL])
                        ->all();

        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $revistas = Revista::find()->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->where(['<>', 'id', 6])->all();
        
        $resoluciones = Nombramiento::find()
                    ->select('resolucion')->distinct()
                    ->orderBy('resolucion')->all();

        $resolucionesext =Nombramiento::find()
                    ->select('resolucionext')->distinct()
                    ->orderBy('resolucionext')->all();

        if(isset($param['Nombramiento']['cargo']) && $param['Nombramiento']['cargo']!='')
            $model->cargo = $param['Nombramiento']['cargo'];
        if(isset($param['Nombramiento']['docente']) && $param['Nombramiento']['docente']!='')
            $model->docente = $param['Nombramiento']['docente'];
        if(isset($param['Nombramiento']['revista']) && $param['Nombramiento']['revista']!='')
            $model->revista = $param['Nombramiento']['revista'];
        if(isset($param['Nombramiento']['condicion']) && $param['Nombramiento']['condicion']!='')
            $model->condicion = $param['Nombramiento']['condicion'];
        if(isset($param['Nombramiento']['resolucion']) && $param['Nombramiento']['resolucion']!='')
            $model->resolucion = $param['Nombramiento']['resolucion'];
        if(isset($param['Nombramiento']['resolucionext']) && $param['Nombramiento']['resolucionext']!='')
            $model->resolucionext = $param['Nombramiento']['resolucionext'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'suplentes' => $suplentes,
        
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            
            'resoluciones' => $resoluciones,
            'resolucionesext' => $resolucionesext,
            'param' => $param,
        
        ]);
    }

    /**
     * Displays a single Nombramiento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $origen = urldecode(Yii::$app->request->referrer);
        $existe = strpos($origen, 'nombramiento/index' );
        if ($existe > 0)
            Yii::$app->session->set('urlorigen', $origen.'#'.$id);

        $model = $this->findModel($id);
        $searchModel = new NombramientoSearch();
        $dataProvider = $searchModel->providerxsuplente($model->suplente);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Nombramiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nombramiento();
        $model->scenario = $model::SCENARIO_ABMNOMBRAMIENTO;

        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $revistas = Revista::find()->where(['<>', 'id', 6])->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()
                        ->where(['<>','id',Globales::COND_SUPL])
                        ->andWhere(['<>', 'id', 6])
                        ->all();
        $suplentes = Nombramiento::find()->all();
        $extensiones = Extension::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            
            
            $fechaInicio_explode = explode("/",$model->fechaInicio);
            //return count($fechaInicio_explode);
            if(count($fechaInicio_explode) > 1){
                $fechaInicio_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaInicio_explode[1], $fechaInicio_explode[0], $fechaInicio_explode[2]));
                $model->fechaInicio = $fechaInicio_nuevo;
            }else{
                $model->fechaInicio = null;
            }
            
            $fechaFin_explode = explode("/",$model->fechaFin);

            if(count($fechaFin_explode) > 1){
                $fechaFin_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaFin_explode[1], $fechaFin_explode[0], $fechaFin_explode[2]));
                $model->fechaFin = $fechaFin_nuevo;
            }else{
                $model->fechaFin = null;
            }

            $fechaInicioext_explode = explode("/",$model->fechaInicioext);
            //return count($fechaInicioext_explode);
            if(count($fechaInicioext_explode) > 1){
                $fechaInicioext_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaInicioext_explode[1], $fechaInicioext_explode[0], $fechaInicioext_explode[2]));
                $model->fechaInicioext = $fechaInicioext_nuevo;
            }else{
                $model->fechaInicioext = null;
            }
            
            $fechaFinext_explode = explode("/",$model->fechaFinext);

            if(count($fechaFinext_explode) > 1){
                $fechaFinext_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaFinext_explode[1], $fechaFinext_explode[0], $fechaFinext_explode[2]));
                $model->fechaFinext = $fechaFinext_nuevo;
            }else{
                $model->fechaFinext = null;
            }
                        
            //return $nuevafecha2;
            $model->activo = 1;
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        
        return $this->render('create', [
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            'suplentes' => $suplentes,
            'extensiones' => $extensiones,
        ]);
    }

    /**
     * Updates an existing Nombramiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_ABMNOMBRAMIENTO;

        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $revistas = Revista::find()->where(['<>', 'id', 6])->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->andWhere(['<>', 'id', 6])->all();
        $suplentes = Nombramiento::find()->all();
        $extensiones = Extension::find()->all();

        $fechaInicio_explode = explode("-",$model->fechaInicio);
            
        if(count($fechaInicio_explode) > 1){
            $fechaInicio_nuevo = date("d/m/Y", mktime(0, 0, 0, $fechaInicio_explode[1], $fechaInicio_explode[2], $fechaInicio_explode[0]));
            $model->fechaInicio = $fechaInicio_nuevo;
        }else{
            $model->fechaInicio = null;
        }

        $fechaFin_explode = explode("-",$model->fechaFin);
        if(count($fechaFin_explode) > 1){
            $fechaFin_nuevo = date("d/m/Y", mktime(0, 0, 0, $fechaFin_explode[1], $fechaFin_explode[2], $fechaFin_explode[0]));
            $model->fechaFin = $fechaFin_nuevo;
        }else{
            $model->fechaFin = null;
        }

        $fechaInicioext_explode = explode("-",$model->fechaInicioext);
            
        if(count($fechaInicioext_explode) > 1){
            $fechaInicioext_nuevo = date("d/m/Y", mktime(0, 0, 0, $fechaInicioext_explode[1], $fechaInicioext_explode[2], $fechaInicioext_explode[0]));
            $model->fechaInicioext = $fechaInicioext_nuevo;
        }else{
            $model->fechaInicioext = null;
        }

        $fechaFinext_explode = explode("-",$model->fechaFinext);
        if(count($fechaFinext_explode) > 1){
            $fechaFinext_nuevo = date("d/m/Y", mktime(0, 0, 0, $fechaFinext_explode[1], $fechaFinext_explode[2], $fechaFinext_explode[0]));
            $model->fechaFinext = $fechaFinext_nuevo;
        }else{
            $model->fechaFinext = null;
        }



        if ($model->load(Yii::$app->request->post())) {


            $fechaInicio_explode = explode("/",$model->fechaInicio);
            //return count($fechaInicio_explode);
            if(count($fechaInicio_explode) > 1){
                $fechaInicio_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaInicio_explode[1], $fechaInicio_explode[0], $fechaInicio_explode[2]));
                $model->fechaInicio = $fechaInicio_nuevo;
            }else{
                $model->fechaInicio = null;
            }
            
            $fechaFin_explode = explode("/",$model->fechaFin);

            if(count($fechaFin_explode) > 1){
                $fechaFin_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaFin_explode[1], $fechaFin_explode[0], $fechaFin_explode[2]));
                $model->fechaFin = $fechaFin_nuevo;
            }else{
                $model->fechaFin = null;
            }

            $fechaInicioext_explode = explode("/",$model->fechaInicioext);
            //return count($fechaInicioext_explode);
            if(count($fechaInicioext_explode) > 1){
                $fechaInicioext_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaInicioext_explode[1], $fechaInicioext_explode[0], $fechaInicioext_explode[2]));
                $model->fechaInicioext = $fechaInicioext_nuevo;
            }else{
                $model->fechaInicioext = null;
            }
            
            $fechaFinext_explode = explode("/",$model->fechaFinext);

            if(count($fechaFinext_explode) > 1){
                $fechaFinext_nuevo = date("Y-m-d", mktime(0, 0, 0, $fechaFinext_explode[1], $fechaFinext_explode[0], $fechaFinext_explode[2]));
                $model->fechaFinext = $fechaFinext_nuevo;
            }else{
                $model->fechaFinext = null;
            }
            
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('update', [
                'model' => $model,

                'cargos' => $cargos,
                'docentes' => $docentes,
                'revistas' => $revistas,
                'divisiones' => $divisiones,
                'condiciones' => $condiciones,
                'suplentes' => $suplentes,
                'extensiones' => $extensiones,
            ]);
        }
        return $this->render('update', [
                'model' => $model,

                'cargos' => $cargos,
                'docentes' => $docentes,
                'revistas' => $revistas,
                'divisiones' => $divisiones,
                'condiciones' => $condiciones,
                'suplentes' => $suplentes,
                'extensiones' => $extensiones,
            ]);

    }

    /**
     * Deletes an existing Nombramiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->suplente == null){

            $titular = $model->find()
                        ->where(['suplente' => $model->id])
                        ->one();
            
            if ($titular != null){
                $modelTitular = $this->findModel($titular->id);
                $modelTitular->suplente = null;
                $modelTitular->save();
                //return $this->redirect(['index']); 
            }
            
            $model->delete();
        }else{
            Yii::$app->session->setFlash('error', "No se puede borrar el nombramiento ya que tiene un suplente asignado. Elimine el suplente para proceder.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Nombramiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nombramiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nombramiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

        public function actionAsignarsuplente2()
    {
        
        $cargox = $_REQUEST['cargox'];
        $idx = $_REQUEST['idx'];

        $model = Nombramiento::findOne($idx);
        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $revistas = Revista::find()->where(['<>', 'id', 6])->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->where(['<>', 'id', 6])->all();
        $extensiones = Extension::find()->all();
        
        $subQuery = Nombramiento::find()->select('suplente')->all();
        $query  = Nombramiento::find()
            ->where(['cargo'=>$cargox,])
            ->andWhere(['<>','id', $idx])
            ->andWhere(['=','condicion', Globales::COND_SUPL])//suplente
            ->andWhere('id NOT IN (SELECT suplente from nombramiento where suplente is not null)')->all();
        //$suplentes = $query->all();
       
         $suplente = ArrayHelper::toArray($query, [
        'app\models\Nombramiento' => [
            'id',
            'nombre' => function ($supl) {
             return $supl->getLabel();
            }],
         ]);

         
         
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('createsuplente', [
            'model' => $model,

            'cargos' => $cargos,
            'docentes' => $docentes,
            'revistas' => $revistas,
            'divisiones' => $divisiones,
            'condiciones' => $condiciones,
            'suplentes' => $suplente,
            'extensiones' => $extensiones,
        ]);
    }


    public function actionAsignarsuplente()
    {
        $cargox = $_REQUEST['cargox'];
        $idx = $_REQUEST['idx'];
        
        $nombramientoParent = Nombramiento::findOne($idx);
        if($nombramientoParent->suplente == null){

            $model = new Nombramiento();
            $model->scenario = $model::SCENARIO_ABMNOMBRAMIENTO;
            $model->cargo = $cargox;
            $model->condicion = Globales::COND_SUPL;
             $model->horas = $nombramientoParent->horas;

            $cargos = Cargo::find()->all();
            
            $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
            $revistas = Revista::find()->where(['<>', 'id', 6])->all();
            $divisiones = Division::find()->all();
            $extensiones = Extension::find()->all();
            $condiciones = Condicion::find()->where(['<>', 'id', 6])->all();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $nombramientoParent->suplente = $model->id;
                $nombramientoParent->save();
                return $this->redirect(['view', 'id' => $idx]);
            }

            return $this->renderAjax('createsuplente', [
                'model' => $model,
                'nombramientoParent' => $nombramientoParent,
                'docentes' => $docentes,
                'revistas' => $revistas,
                'divisiones' => $divisiones,
                'extensiones' => $extensiones,
                'cargos' => $cargos,
                'revistas' => $revistas,
                'condiciones' => $condiciones,
            ]);

        }else{
            return '<div class="alert alert-danger">
                        <strong>Error.</strong> Para agregar un suplente debe borrar primero el suplente ya asignado para este cargo.
                    </div>';
        }
        
        
        
    }

    public function actionUpdatesuplente($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_ABMNOMBRAMIENTO;
        $idx = $_REQUEST['idx'];
        $nombramientoParent = Nombramiento::findOne($idx);

        $cargos = Cargo::find()->all();
        $docentes = Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $revistas = Revista::find()->where(['<>', 'id', 6])->all();
        $divisiones = Division::find()->all();
        $condiciones = Condicion::find()->where(['<>', 'id', 6])->all();
        
        $extensiones = Extension::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $idx]);
        }

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('updatesuplente', [
                'model' => $model,
                'nombramientoParent' => $nombramientoParent,
                'docentes' => $docentes,
                'revistas' => $revistas,
                'divisiones' => $divisiones,
                'extensiones' => $extensiones,
                'cargos' => $cargos,
                'revistas' => $revistas,
                'condiciones' => $condiciones,
            ]);
        }
        return $this->render('updatesuplente', [
                'model' => $model,
                'nombramientoParent' => $nombramientoParent,
                'docentes' => $docentes,
                'revistas' => $revistas,
                'divisiones' => $divisiones,
                'extensiones' => $extensiones,
                'cargos' => $cargos,
                'revistas' => $revistas,
                'condiciones' => $condiciones,
            ]);

    }


     public function actionAbmdivision($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_ABMDIVISION;

        
        $divisiones = Division::find()->all();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['reporte/preceptores']);
        }

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('abmdivision', [
                'model' => $model,
                'divisiones' => $divisiones,
                
            ]);
        }
        return $this->render('abmdivision', [
                'model' => $model,
                'divisiones' => $divisiones,
                
            ]);

    }

    public function actionAbmpreceptor($nom,$div)
    {
        
        if($nom == 0)
            $model = new Nombramiento();
        else
            $model = $this->findModel($nom);
        $model->scenario = $model::SCENARIO_ABMDIVISION;
        
        $preceptores = Nombramiento::find()
                ->joinWith(['docente0'])
                ->where(['cargo' => Globales::CARGO_PREC])
                ->orderBy('docente.apellido, docente.nombre')->all();

        if ($model->load(Yii::$app->request->post())) {
            //return var_dump(Yii::$app->request->post());

            //$nomx = Nombramiento::findOne(Yii::$app->request->post()['Nombramiento']['id']);
            if($nom != 0){
                 $model3 = $this->findModel($nom);
                 $model3->division = null;
                 $model3->save();
            }
               
            $model2 = $this->findModel(Yii::$app->request->post()['Nombramiento']['id']);
            $model2->division = $div;
            $model2->save();
            return $this->redirect(['reporte/preceptores/preceptores']);
        }

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('abmpreceptor', [
                'model' => $model,
                'preceptor' => $preceptores,
                
            ]);
        }
        return $this->render('abmpreceptor', [
                'model' => $model,
                'preceptor' => $preceptores,
                
            ]);

    }    


    

    
}
