<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\Comision;
use app\models\Division;
use app\modules\optativas\models\Optativa;
use app\modules\optativas\models\Aniolectivo;
use app\modules\optativas\models\Estadomatricula;
use app\modules\optativas\models\MatriculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MatriculaController implements the CRUD actions for Matricula model.
 */
class MatriculaController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [1]);
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
     * Lists all Matricula models.
     * @return mixed
     */
    public function actionIndex()
    {
        $param = Yii::$app->request->queryParams;
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;
        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $aniolectivos = Aniolectivo::find()->all();

        $comisiones = Matricula::find()->all();

        if(isset($param['Matricula']['aniolectivo']))
            $model->aniolectivo = $param['Matricula']['aniolectivo'];
        if(isset($param['Matricula']['comision']))
            $model->comision = $param['Matricula']['comision'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aniolectivos' => $aniolectivos,
            'param' => $param,
            'model' => $model,
            'comisiones' => $comisiones,
        ]);
    }

    /**
     * Displays a single Matricula model.
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
     * Creates a new Matricula model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;
        $alumnos = Alumno::find()
                    ->orderBy('apellido, nombre')
                    ->all();
        $optativas = Optativa::find()->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['optativa0', 'optativa0.actividad0'])
                        ->orderBy('actividad.nombre', 'comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'alumnos' => $alumnos,
            'optativas' => $optativas,
            'comisiones' => $comisiones,
            'estadosmatricula' => $estadosmatricula,
            'divisiones' => $divisiones,


        ]);
    }

    /**
     * Updates an existing Matricula model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        //$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
        $alumnos = Alumno::find()
                    ->orderBy('apellido, nombre')
                    ->all();
        $optativas = Optativa::find()->all();
        $comisiones = Comision::find()
                        ->joinWith(['optativa0', 'optativa0.actividad0'])
                        ->orderBy('actividad.nombre', 'comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->all();

        if ($model->load(Yii::$app->request->post())){
            //date_default_timezone_set('America/Argentina/Buenos_Aires');
            //$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'alumnos' => $alumnos,
            'optativas' => $optativas,
            'comisiones' => $comisiones,
            'estadosmatricula' => $estadosmatricula,
            'divisiones' => $divisiones,
        ]);
    }

    /**
     * Deletes an existing Matricula model.
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
     * Finds the Matricula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Matricula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Matricula::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
