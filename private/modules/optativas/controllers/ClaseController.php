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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,8,9]);
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

        
        $horastotalactual = $searchModel->getHorasTotalactual($com);
        $horaspresencialactual = $searchModel->getHorasParcialactual($com, 1);//presencial 1
        $horasnopresencialactual = $searchModel->getHorasParcialactual($com, 2);//no presencial 2
        $horasvisitaactual = $searchModel->getHorasParcialactual($com, 3);//visita 3
        
        $submenu = $this->renderPartial('_submenu', [

            'duracion' => $duracion,
            'horastotalactual' => $horastotalactual,
            'horaspresencialactual' => $horaspresencialactual,
            'horasnopresencialactual' => $horasnopresencialactual,
            'horasvisitaactual' => $horasvisitaactual,

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

        ]); 
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar una <b>Actividad Optativa</b>');
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
            $comsion = $this->findModel($id)->comision;
            $dataProvider = $searchModel->alumnosxcomision($comsion);
            $inasistenciasdeldia = Inasistencia::find()
                        ->where(['clase' => $id])
                        ->all();
            $alumnosdecomsion = Matricula::find()
                        ->select('id')
                        ->where(['comision' => $comsion])
                        ->all();

           
            return $this->render('view', [
                'model' => $this->findModel($id),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'inasistenciasdeldia' => $inasistenciasdeldia,
                'alumnosdecomsion' => $alumnosdecomsion,
               

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar una <b>Actividad Optativa</b>');
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
            $model->comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;

            $tiposclase = Tipoclase::find()->all();
            if ($model->load(Yii::$app->request->post())) {
                if($model->validate()){
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    
                    Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar una <b>Actividad Optativa</b>');
                    return $this->redirect(['create']);
                }
                
            }

            return $this->render('create', [
                'model' => $model,
                'tiposclase' => $tiposclase,

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar una <b>Actividad Optativa</b>');
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

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'tiposclase' => $tiposclase,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar una <b>Actividad Optativa</b>');
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
        $this->findModel($id)->delete();

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
