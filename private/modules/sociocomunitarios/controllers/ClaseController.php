<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\modules\curriculares\models\Clase;
use app\modules\curriculares\models\Myfunction;
use app\modules\curriculares\models\Acta;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Espaciocurricular;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\Tipoclase;
use app\modules\curriculares\models\ClaseSearch;
use app\modules\curriculares\models\Detalletardanza;
use app\modules\curriculares\models\Inasistencia;
use app\modules\curriculares\models\MatriculaSearch;
use app\modules\curriculares\models\Tardanza;
use app\modules\curriculares\models\Tipoasistencia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\switchinput\SwitchInput;


/**
 * ClaseController implements the CRUD actions for Clase model.
 */
class ClaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'viewgrid', 'claseshoy', 'claseinterhoy'],
                'rules' => [
                    [
                        'actions' => ['index', 'claseinterhoy'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14,20]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'claseshoy'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $clase = Clase::findOne(Yii::$app->request->queryParams['id']);
                                if(
                                    count(Acta::find()->where(['comision' => $clase->comision])->andWhere(['estadoacta' => 2])->all()) > 0){
                                    Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                    return false;
                                }else{
                                    Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                    return in_array (Yii::$app->user->identity->role, [1,8]);
                                }
                                
                            }catch(\Exception $exception){
                                return in_array (Yii::$app->user->identity->role, [1,8]);
                            }
                            return in_array (Yii::$app->user->identity->role, [1,8]);
                        }

                    ],
                    /*[
                        'actions' => ['claseshoy', 'claseinterhoy'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return in_array (Yii::$app->user->identity->role, [1,9]);
                        }

                    ],*/
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                
                                if (in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14,20])){
                                    $model = $this->findModel($_GET['id']);
                                    if($model->fechaconf == 1 && $model->hora != null)
                                        return true;
                                    else{
                                        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Para cargar la asistencia debe tener definido <b>fecha y hora</b>');
                                        return $this->redirect(['index']);
                                    }
                                }
                                else
                                    return false;
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
     * Lists all Clase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new ClaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);

        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
           $comision = Comision::findOne($com);
        $optativa = Espaciocurricular::findOne($comision->espaciocurricular);
        $duracion = $optativa->duracion;

        $inasistencias = Inasistencia::find()
                            ->joinWith(['clase0'])
                            ->where(['clase.comision' => $com])
                            ->all();

        
        $horastotalactual = $searchModel->getHorasTotalactual($com);
        $horaspresencialactual = $searchModel->getHorasParcialactual($com, 1);//presencial 1
        $horasnopresencialactual = $searchModel->getHorasParcialactual($com, 2);//no presencial 2
        $horasvisitaactual = $searchModel->getHorasParcialactual($com, 3);//visita 3
        
        /*$submenu = $this->renderPartial('_submenu', [

            'duracion' => round($duracion,2),
            'horastotalactual' => round($horastotalactual,2),
            'horaspresencialactual' => round($horaspresencialactual,2),
            'horasnopresencialactual' => round($horasnopresencialactual,2),
            'horasvisitaactual' => round($horasvisitaactual,2),

        ]);

            $this->view->params['submenu'] = $submenu;*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'duracion' => $duracion,
            'horastotalactual' => $horastotalactual,
            'horaspresencialactual' => $horaspresencialactual,
            'horasnopresencialactual' => $horasnopresencialactual,
            'horasvisitaactual' => $horasvisitaactual,
            'inasistencias' => $inasistencias,

        ]); 
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
                return $this->redirect(['/sociocomunitarios']);
        }
        
    }

    /**
     * Displays a single Clase model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $searchModel = new MatriculaSearch();
            $comision = $this->findModel($id)->comision;
            $dataProvider = $searchModel->alumnosxcomision($comision);
            $inasistenciasdeldia = Inasistencia::find()
                        ->where(['clase' => $id])
                        ->all();
            $alumnosdecomision = Matricula::find()
                        ->select('id')
                        ->where(['comision' => $comision])
                        ->all();

            $alumnosdecomisionprueba = Matricula::find()
                        ->joinWith(['alumno0'])
                        ->where(['comision' => $comision])
                        ->orderBy('alumno.apellido, alumno.nombre')
                        ->all();

            $listInasistenciasdeldia=ArrayHelper::map($inasistenciasdeldia,'matricula','matricula');
            $echodiv='';

            $tardanzasdeldia = Detalletardanza::find()
                        ->where(['clase' => $id])
                        ->all();

            $listtardanzasdeldia=ArrayHelper::map($tardanzasdeldia,'matricula','tardanza');
            $listtardanzasdeldiaaux=ArrayHelper::map($tardanzasdeldia,'matricula','matricula');
            //array_keys($listtardanzasdeldia, $matricula["id"])

            $tardanzas = Tardanza::find()->all();
            $tardanzas=ArrayHelper::map($tardanzas,'id','descripcion');
            
            
            foreach ($alumnosdecomisionprueba as $matricula) {

                $sel = in_array ($matricula["id"], $listInasistenciasdeldia);

                
                if(in_array ($matricula["id"], $listtardanzasdeldiaaux)){
                    $seltar = $listtardanzasdeldia[$matricula["id"]];
                }else{
                    $seltar = 0;
                }
                if($sel)
                    $paneltype = 'danger';
                else
                    $paneltype = 'success';

                $echodiv .= '<div class="col-6 col-md-6 col-lg-4">';
                $echodiv .= '<div class="panel panel-'.$paneltype.'" style="height: 25vh;">';
                $echodiv .= '<div class="panel-heading">'.$matricula["alumno0"]["apellido"].', '.$matricula["alumno0"]["nombre"].'</div>';
                $echodiv .= '<div class="panel-body"><span class ="pull-right">';
                //$echodiv .= Html::checkbox("scripts", $sel, ['label' => 'Se Ausentó', 'value' => $matricula["id"]]);
                $echodiv .= SwitchInput::widget([
                            'name' => $matricula["id"],
                            'value'=>$sel,
                            'pluginOptions' => [
                                'onText' => 'Ausente',
                                'offText' => 'Presente',
                                'offColor' => 'success',
                                'onColor' => 'danger',
                            ]
                        ]);
                $echodiv .= 'Tardanza: '.Html::dropDownList($matricula["id"], $seltar, $tardanzas, ['prompt' => 'No', 'class' => 'your_class']	);    
                $echodiv .= '</span></div>
                                </div>
                              </div>';
               // break;
            }
            


           
            return $this->render('view', [
                'model' => $this->findModel($id),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'inasistenciasdeldia' => $inasistenciasdeldia,
                'alumnosdecomision' => $alumnosdecomision,
                'alumnosdecomisionprueba' => $alumnosdecomisionprueba,
                'echodiv' => $echodiv,
               
                'listtardanzasdeldia' => $listtardanzasdeldia,
                
               

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
                return $this->redirect(['/sociocomunitarios']);
        }
    }

    public function actionViewgrid($id)
    {
        $this->layout = null;
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $searchModel = new MatriculaSearch();
            $comision = $this->findModel($id)->comision;
            $dataProvider = $searchModel->alumnosxcomision($comision);
            $inasistenciasdeldia = Inasistencia::find()
                        ->where(['clase' => $id])
                        ->all();
            $alumnosdecomision = Matricula::find()
                        ->select('id')
                        ->where(['comision' => $comision])
                        ->all();

            

                     


           
            return $this->render('viewgrid', [
                'model' => $this->findModel($id),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'inasistenciasdeldia' => $inasistenciasdeldia,
                'alumnosdecomision' => $alumnosdecomision,
                'clase' => $id,
                               

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
                return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Creates a new Clase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Clase();
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $model->comision = $com;
            
            $tiposclase = Tipoclase::find()->all();
            $tiposasistencia = Tipoasistencia::find()->all();

            if ($model->load(Yii::$app->request->post())) {
                $model->fechaconf = Yii::$app->request->post()['Clase']['fechaconf'];
                $mes = Yii::$app->request->post()['meses'];
                if ($mes<10) {
                    $mes = '0'.$mes;
                }
                if($model->fechaconf == 0){
                    
                    $date = '2019-'.$mes.'-01';
                    $model->fecha =  $date;
                    $model->hora = null;
                    $model->save();
                    return $this->redirect(['index']);
                }
                if($model->save()){
                    if($model->fechaconf == 1 && $model->hora!=null)
                        return $this->redirect(['index']);
                        //return $this->redirect(['view', 'id' => $model->id]);
                    else
                        return $this->redirect(['index']);
                }
            }
            $mesx = 0;
            if($model->fechaconf ==0){
                $mesx = Yii::$app->formatter->asDate($model->fecha, 'n');
            }
            return $this->render('create', [
                'model' => $model,
                'tiposclase' => $tiposclase,
                'tiposasistencia' => $tiposasistencia,
                'mesx' => $mesx,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }

    }

    /**
     * Updates an existing Clase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $this->layout = 'main';
        $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        if($com != 0){
            $model = $this->findModel($id);
            $tiposclase = Tipoclase::find()->all();
            $tiposasistencia = Tipoasistencia::find()->all();

            if ($model->load(Yii::$app->request->post())) {
                $model->fechaconf = Yii::$app->request->post()['Clase']['fechaconf'];
                $mes = Yii::$app->request->post()['meses'];
                if ($mes<10) {
                    $mes = '0'.$mes;
                }
                if($model->fechaconf == 0){
                    
                    $date = '2019-'.$mes.'-01';
                    $model->fecha =  $date;
                    $model->hora = null;
                    $model->save();
                    return $this->redirect(['index']);
                }
                if($model->save())
                    if($model->fechaconf == 1 && $model->hora!=null)
                        return $this->redirect(['view', 'id' => $model->id]);
                    else
                        return $this->redirect(['index']);
            }
            $mesx = 0;
            if($model->fechaconf ==0){
                $mesx = Yii::$app->formatter->asDate($model->fecha, 'M');
            }
            return $this->render('update', [
                'model' => $model,
                'tiposclase' => $tiposclase,
                'tiposasistencia' => $tiposasistencia,
                'mesx' => $mesx,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Proyecto Sociocomunitario</b>');
            return $this->redirect(['/sociocomunitarios']);
        }
    }

    /**
     * Deletes an existing Clase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';

        try{

            $this->findModel($id)->delete();

        }catch(\Exception $exception){
            Yii::$app->session->setFlash('error', "No se puede borrar una clase que tiene cargadas inasistencias. Si desea proceder deberá poner a los alumnos de la misma como presentes.");
        }
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function claseHoyView(){
        $this->layout = 'main';
        $claseHoyView = Myfunction::claseHoyView(2);
        

        return $this->render('claseshoy', [
            'searchModel' => $claseHoyView['searchModel'],
            'dataProvider' => $claseHoyView['dataProvider'],
            'echo' => $claseHoyView['echo'],
            'echo2' => $claseHoyView['echo2'],
        ]); 
    }


    public function actionClaseshoy()
    {
        return $this->claseHoyView();
       
    }

    public function actionClaseinterhoy($id)
    {
        $this->layout = 'main';

        $clase = $this->findModel($id);

        $_SESSION['aniolectivox'] = $clase->comision0->espaciocurricular0->aniolectivo;
        $_SESSION['comisiontsx'] = $clase->comision;

        

        return $this->redirect(['view', 'id' => $id]);
    }
}
