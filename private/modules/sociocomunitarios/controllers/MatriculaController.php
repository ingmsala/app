<?php

namespace app\modules\sociocomunitarios\controllers;

use app\config\Globales;
use Yii;
use app\models\Division;
use app\modules\curriculares\models\Admisionoptativa;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Estadomatricula;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\MatriculaSearch;
use app\modules\curriculares\models\Espaciocurricular;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'create2'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                //return (in_array (Yii::$app->user->identity->role, [1]) || in_array(Yii::$app->user->identity->username, Globales::psc));
                                return in_array (Yii::$app->user->identity->role, [1]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['create2'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['listado'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
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
    public function actionListado()
    {
        $param = Yii::$app->request->queryParams;
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;
        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);
        $aniolectivos = Aniolectivo::find()->orderBy('id DESC')->all();

        if(isset($param['Matricula']['aniolectivo']))
            $model->aniolectivo = $param['Matricula']['aniolectivo'];
        if(isset($param['Matricula']['comision']))
            $model->comision = $param['Matricula']['comision'];

        return $this->render('listado', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aniolectivos' => $aniolectivos,
            'param' => $param,
            'model' => $model,
            
        ]);

    
    }
    public function actionIndex()
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $param = Yii::$app->request->queryParams;
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;
        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);
        $aniolectivos = Aniolectivo::find()->where(['id' => 3])->orderBy('id DESC')->all();

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
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
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
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $al = Aniolectivo::find()->where(['activo' => 1])->one();
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;
        $alumnos = Alumno::find()
                    ->orderBy('apellido, nombre')
                    ->all();
        $optativas = Espaciocurricular::find()->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['espaciocurricular0', 'espaciocurricular0.actividad0'])
                        ->where(['espaciocurricular.tipoespacio' => 2])
                        ->andWhere(['espaciocurricular.aniolectivo' => $al->id])
                        ->orderBy('actividad.nombre', 'comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $param = Yii::$app->request->post();

            $alumnos2 = $param['Matricula']['alumno'];
            $divi = $param['Matricula']['division'];
            $comi = $param['Matricula']['comision'];

            foreach ($alumnos2 as $alumno) {
                $model2 = new Matricula();
                $model2->alumno = $alumno;
                $model2->fecha = date('Y-m-d');
                $model2->estadomatricula = 1;
                $model2->division = $divi;
                $model2->comision = $comi;
                $model2->save();
            }

            /*$model->fecha = date('Y-m-d');
            $model->estadomatricula = 1;
            $model->save();*/
            Yii::$app->session->setFlash('success', 'Se realizó la inscripción correctamente');
            return $this->redirect(['index']);
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

    public function actionCreate2()
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $al = Aniolectivo::find()->where(['activo' => 1])->one();
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;
        $alumnos = Alumno::find()
                    ->orderBy('apellido, nombre')
                    ->all();
        $optativas = Espaciocurricular::find()->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['espaciocurricular0', 'espaciocurricular0.actividad0'])
                        ->where(['espaciocurricular.tipoespacio' => 2])
                        ->andWhere(['espaciocurricular.aniolectivo' => $al->id])
                        ->orderBy('actividad.nombre', 'comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $param = Yii::$app->request->post();

            $alumnos2 = $param['Matricula']['documentos'];
            $divi = $param['Matricula']['division'];
            $comi = $param['Matricula']['comision'];

            $alumnos2 = explode(';', $alumnos2);
            //return var_dump($alumnos2);
            

            foreach ($alumnos2 as $alumno) {
                $alumno = substr($alumno, -8);
                $alu = Alumno::find()->where(['documento' => $alumno])->one();
                $model2 = new Matricula();
                $model2->alumno = $alu->id;
                $model2->fecha = date('Y-m-d');
                $model2->estadomatricula = 1;
                $model2->division = $divi;
                $model2->comision = $comi;
                
                $model2->save();
            }

            /*$model->fecha = date('Y-m-d');
            $model->estadomatricula = 1;
            $model->save();*/
            Yii::$app->session->setFlash('success', 'Se realizó la inscripción correctamente');
            return $this->redirect(['index']);
        }

        return $this->render('create2', [
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
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $model = $this->findModel($id);
        //date_default_timezone_set('America/Argentina/Buenos_Aires');
        //$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
        $alumnos = Alumno::find()
                    ->orderBy('apellido, nombre')
                    ->all();
        $optativas = Espaciocurricular::find()->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['espaciocurricular0', 'espaciocurricular0.actividad0'])
                        ->where(['espaciocurricular.tipoespacio' => 1])
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

    public function actionInscripcion($documento)
    {
        $this->layout = 'mainautogestion';
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;
        $alumnos = Alumno::find()
                    ->where(['documento' => $documento])
                    ->orderBy('apellido, nombre')
                    ->all();
        $alumno = Alumno::find()
                    ->where(['documento' => $documento])
                    ->one();
        $model->alumno = $alumno->id;
        $admision = Admisionoptativa::find()->where(['alumno' => $alumno->id])->all();
        $admision = ArrayHelper::map($admision,'id','curso');
        if(count($admision)==0)
            $admision =[99];
        $optativas = Espaciocurricular::find()
                        ->where(['in', 'curso', $admision])
                        ->orWhere(['curso' => $alumno->curso])
                        ->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['espaciocurricular0', 'espaciocurricular0.actividad0','espaciocurricular0.aniolectivo0'])
                        ->where(['in', 'optativa.curso', $admision])
                        //->orWhere(['optativa.curso' => $alumno->curso])
                        ->andWhere(['aniolectivo.activo' => 1])
                        ->orderBy('aniolectivo.nombre', 'actividad.nombre', 'comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->where(['id' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->fecha = date('Y-m-d');
            $model->estadomatricula = 1;

            if($this->controlDeCupo($model->comision)){
                if($this->controlDeDuplicadoMismoCurso($model->alumno, count($admision))){
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash('danger', "El alumno ya está matriculado en la cantidad máxima de Espacios Optativos para este año lectivo");
                }
                
            }else{
                            Yii::$app->session->setFlash('danger', "El Proyecto Sociocomunitario seleccionado tiene el cupo completo. Deberá inscribirse en uno diferente");

            }
            
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
     * Finds the Matricula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Matricula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function controlDeCupo($comision)
    {
       
        $matriculas = count(Matricula::find()->where(['comision' => $comision])->all());
        $comision = Comision::findOne($comision);
        if( $matriculas < $comision->cupo)
            return true;
        return false;
    }

    protected function controlDeDuplicadoMismoCurso($alumno, $admision)
    {
       
        $matriculas = count(Matricula::find()
                                ->joinWith(['comision0.espaciocurricular0.aniolectivo0'])
                                ->where(['alumno' => $alumno])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->all()) - $admision;
        
        if( $matriculas > 0)
            return false;
        return true;
    }

    protected function findModel($id)
    {
        if (($model = Matricula::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
