<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Clase;
use app\modules\optativas\models\Comision;
use app\modules\optativas\models\Optativa;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\Tipoclase;
use app\modules\optativas\models\ClaseSearch;
use app\modules\optativas\models\Inasistencia;
use app\modules\optativas\models\MatriculaSearch;
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'viewgrid'],
                'rules' => [
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14]);
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
                                return in_array (Yii::$app->user->identity->role, [1,8,9]);
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
                                
                                if (in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14])){
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
           $comision = Comision::findOne($com);
        $optativa = Optativa::findOne($comision->optativa);
        $duracion = $optativa->duracion;

        $inasistencias = Inasistencia::find()
                            ->joinWith(['clase0'])
                            ->where(['clase.comision' => $com])
                            ->all();

        
        $horastotalactual = $searchModel->getHorasTotalactual($com);
        $horaspresencialactual = $searchModel->getHorasParcialactual($com, 1);//presencial 1
        $horasnopresencialactual = $searchModel->getHorasParcialactual($com, 2);//no presencial 2
        $horasvisitaactual = $searchModel->getHorasParcialactual($com, 3);//visita 3
        
        $submenu = $this->renderPartial('_submenu', [

            'duracion' => round($duracion,2),
            'horastotalactual' => round($horastotalactual,2),
            'horaspresencialactual' => round($horaspresencialactual,2),
            'horasnopresencialactual' => round($horasnopresencialactual,2),
            'horasvisitaactual' => round($horasvisitaactual,2),

        ]);

            $this->view->params['submenu'] = $submenu;

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
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
                return $this->redirect(['/optativas']);
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
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
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
            foreach ($alumnosdecomisionprueba as $matricula) {

                $sel = in_array ($matricula["id"], $listInasistenciasdeldia);
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
                $echodiv .= '</span></div>
                                </div>
                              </div>';
            }
            


           
            return $this->render('view', [
                'model' => $this->findModel($id),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'inasistenciasdeldia' => $inasistenciasdeldia,
                'alumnosdecomision' => $alumnosdecomision,
                'alumnosdecomisionprueba' => $alumnosdecomisionprueba,
                'echodiv' => $echodiv,
               

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
                return $this->redirect(['/optativas']);
        }
    }

    public function actionViewgrid($id)
    {
        $this->layout = null;
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
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
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
                return $this->redirect(['/optativas']);
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
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
            $model->comision = $com;
            
            $tiposclase = Tipoclase::find()->all();

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
                'mesx' => $mesx,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
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
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($com != 0){
            $model = $this->findModel($id);
            $tiposclase = Tipoclase::find()->all();

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
                'mesx' => $mesx,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
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
}
