<?php

namespace app\modules\optativas\controllers\autogestion;

use Yii;
use app\models\Division;
use app\models\Preinscripcion;
use app\modules\optativas\models\Admisionoptativa;
use app\modules\optativas\models\AdmisionoptativaSearch;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\CalificacionSearch;
use app\modules\optativas\models\Comision;
use app\modules\optativas\models\Estadomatricula;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\Optativa;
use app\modules\optativas\models\OptativaSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CalificacionController implements the CRUD actions for Calificacion model.
 */
class PreinscripcionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $key1 = Yii::$app->session->has('dni');
                                if (Alumno::find()->where(['dni' => Yii::$app->session->get('dni')])->one() != null)
                                    $key2 = true;
                                else
                                    $key2 = false;
                                if ($key1 and $key2)
                                    return true;
                                else
                                    return $this->redirect(['/optativas/autogestion/inicio']);
                            }catch(\Exception $exception){
                                return $this->redirect(['/optativas/autogestion/inicio']);
                            }
                        }

                    ],

                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'inscripcion' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Calificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'mainautogestion';
        $preinscripcion = Preinscripcion::findOne(1);
        $estadoinscripcion = $preinscripcion->activo;
        if($estadoinscripcion == 0){
            Yii::$app->session->setFlash('error', "No existe un periodo de <b>Inscripción</b> activo.");
            return $this->redirect(['/optativas/autogestion/agenda/index']);
        }

         if($estadoinscripcion == 2){
            Yii::$app->session->setFlash('error', "No existe un periodo de <b>Inscripción</b> activo.");
            //return $this->redirect(['/optativas/autogestion/agenda/index']);
        }
    
        $dni = Yii::$app->session->get('dni');
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;
        $alumnos = Alumno::find()
                    ->where(['dni' => $dni])
                    ->orderBy('apellido, nombre')
                    ->all();
        $alumno = Alumno::find()
                    ->where(['dni' => $dni])
                    ->one();
        $model->alumno = $alumno->id;
        $admision = Admisionoptativa::find()
            ->joinWith('aniolectivo0')
            ->where(['alumno' => $alumno->id])
            ->andWhere(['aniolectivo.activo' => 1])
            ->all();
        $aniolectivo = $admision[0]->aniolectivo0->nombre;
        $admision = ArrayHelper::map($admision,'id','curso');
        if(count($admision)==0)
            $admision =[99];
        $optativas = Optativa::find()
                        ->where(['in', 'curso', $admision])
                        ->orWhere(['curso' => $alumno->curso])
                        ->all();
        $divisiones = Division::find()
                        ->where(['propuesta' => 1])
                        ->all();
        $comisiones = Comision::find()
                        ->joinWith(['optativa0', 'optativa0.actividad0','optativa0.aniolectivo0'])
                        ->where(['in', 'optativa.curso', $admision])
                        //->orWhere(['optativa.curso' => $alumno->curso])
                        ->andWhere(['aniolectivo.activo' => 1])
                        ->orderBy('aniolectivo.nombre, actividad.nombre, comision.nombre')
                        ->all();
        $estadosmatricula = Estadomatricula::find()->where(['id' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->fecha = date('Y-m-d');
            $model->estadomatricula = 1;

            if($this->controlDeCupo($model->comision)){
                $admisionxcurso = Admisionoptativa::find()
                                ->joinWith('aniolectivo0')
                                ->where(['alumno' => $alumno->id])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->andWhere(['curso' => $model->comision0->optativa0->curso])
                                ->all();
                 $admisionxcurso = ArrayHelper::map($admisionxcurso,'id','curso');

                if($this->controlDeDuplicadoMismoCurso($model->alumno, count($admisionxcurso), $model->comision0->optativa0->curso)){
                    $model->save();
                    //Yii::$app->session->setFlash('danger', $model->comision0->optativa0->curso);
                    Yii::$app->session->setFlash('success', "Se realizó la matrícula correctamente. Puede verificar la agenda de clases en esta pantalla.");
                    return $this->redirect(['autogestion/agenda/index', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash('danger', "El alumno ya está matriculado en la cantidad máxima de Espacios Optativos para este año lectivo");
                }
                
            }else{
                            Yii::$app->session->setFlash('danger', "El Espacio Optativo seleccionado tiene el cupo completo. Deberá inscribirse en uno diferente");

            }
            
        }

        $matriculasalumno = Matricula::find()
            ->joinWith(['comision0.optativa0.aniolectivo0'])
            ->where(['alumno' => $alumno->id])
            ->all();
        $matriculasalumno = ArrayHelper::map($matriculasalumno,'comision','comision');
        

        $admisionSearch  = new AdmisionoptativaSearch();
        $dataProviderAdmision = $admisionSearch->porAlumno($alumno->id);

        $optativaSearch  = new OptativaSearch();
        $dataProviderOptativa = $optativaSearch->porCursos($alumno->id);

        return $this->render('index', [
            'model' => $model,
            'alumnos' => $alumnos,
            'optativas' => $optativas,
            'comisiones' => $comisiones,
            'estadosmatricula' => $estadosmatricula,
            'divisiones' => $divisiones,
            'admision' => $dataProviderAdmision,
            'matriculasalumno' => $matriculasalumno,
            'dataProviderOptativa' => $dataProviderOptativa,
            'estadoinscripcion' => $estadoinscripcion,
            'alumno' => $alumno->id,
            'aniolectivo' => $aniolectivo,
            'instancia' => $preinscripcion->descripcion,

        ]);
    
    }

     protected function controlDeCupo($comision)
    {
       
        $matriculas = count(Matricula::find()->where(['comision' => $comision])->all());
        $comision = Comision::findOne($comision);
        if( $matriculas < $comision->cupo)
            return true;
        return false;
    }

    protected function controlDeDuplicadoMismoCurso($alumno, $admision, $curso)
    {
       
        $matriculas = $admision - count(Matricula::find()
                                ->joinWith(['comision0.optativa0.aniolectivo0'])
                                ->where(['alumno' => $alumno])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->andWhere(['curso' => $curso])
                                ->all());
        
        if( $matriculas > 0)
            return true;
        return false;
    }

    public function actionInscripcion($c, $a)
    {
        $model = new Matricula();
        $model->scenario = $model::SCENARIO_CREATE;

        $model->alumno = $a;
        $model->fecha = date('Y-m-d');
        $model->estadomatricula = 1;
        $model->comision = $c;

            if($this->controlDeCupo($c)){
                $admisionxcurso = Admisionoptativa::find()
                                ->joinWith('aniolectivo0')
                                ->where(['alumno' => $a])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->andWhere(['curso' => $model->comision0->optativa0->curso])
                                ->all();
                 $admisionxcurso = ArrayHelper::map($admisionxcurso,'id','curso');

                if($this->controlDeDuplicadoMismoCurso($model->alumno, count($admisionxcurso), $model->comision0->optativa0->curso)){
                    $model->save();
                    //Yii::$app->session->setFlash('danger', $model->comision0->optativa0->curso);
                    Yii::$app->session->setFlash('success', "Se realizó la matrícula correctamente. Puede verificar la agenda de clases en esta pantalla.");
                    return $this->redirect(['autogestion/agenda/index', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash('danger', "El alumno ya está matriculado en la cantidad máxima de Espacios Optativos para este año lectivo");

                }
                
            }else{
                            Yii::$app->session->setFlash('danger', "El Espacio Optativo seleccionado tiene el cupo completo. Deberá inscribirse en uno diferente");

            }
            return $this->redirect(['autogestion/preinscripcion']);
    }

   
}
