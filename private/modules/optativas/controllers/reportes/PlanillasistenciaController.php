<?php

namespace app\modules\optativas\controllers\reportes;

use Yii;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Clase;
use app\modules\curriculares\models\Espaciocurricular;
use app\modules\curriculares\models\InasistenciaSearch;
use app\modules\curriculares\models\SeguimientoSearch;
use app\modules\curriculares\models\Inasistencia;
use app\modules\curriculares\models\Estadomatricula;
use app\modules\curriculares\models\MatriculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use \Datetime;



/**
 * MatriculaController implements the CRUD actions for Matricula model.
 */
class PlanillasistenciaController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13]);
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
        
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
        $comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if($comision != 0){

            $dataProvider = $searchModel->alumnosxcomision($comision);


            $alumnosxcomision = Matricula::find()
                                    ->joinWith(['alumno0'])
                                    ->where(['comision' => $comision])
                                    ->orderBy('alumno.apellido, alumno.nombre')
                                    ->all();

             $alumnosxcomision=ArrayHelper::map($alumnosxcomision,
                    
                    function($model){
                        
                        return $model->alumno0->id;
                        
                    },
                    function($model){
                        
                        return [$model->alumno0->apellido.', '.$model->alumno0->nombre, array_fill(0, 10, 's')];
                    }
            );



    /*

            $faltasdelalumno = Inasistencia::find()
                                ->joinWith(['clase0'])
                                ->where(['matricula' => $id])
                                ->andWhere(['clase.comision' => $comision])
                                ->all();

            $listFaltasdelalumno=ArrayHelper::map($faltasdelalumno,
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model->clase0->fecha, 'dd/MM');
                        
                    },
                    function($model){
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha = date_create($model->clase0->fecha);
                        $hoy = new DateTime("now");
                        $interval = $fecha->diff($hoy);
                        $signo = $interval->format('%R');

                        if ($signo == '+')
                            return "A";
                        else
                            return '';
                    }
            );

            */

            $data = [
                $alumnosxcomision,
                //$listFaltasdelalumno,
                
            ];

            $dataProviderInasistencias = new ArrayDataProvider([
                'allModels' => [

                    'alumno' => $alumnosxcomision,
                    //'clases' => array_fill(0, 10, 's'),

                ],
            ]);

            $com = $this->findModel($comision);
            $optnom = $com->espaciocurricular0->aniolectivo0->nombre.' - '.$com->espaciocurricular0->actividad0->nombre.' <br/> Comisión: '.$com->nombre;


            return $this->render('index', [
                
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'optnom' => $optnom,

            ]);
        }else{
            Yii::$app->session->set('success', '<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Debe seleccionar un <b>Espacio Optativo</b>');
            return $this->redirect(['/optativas']);
        }

    }

 protected function findModel($id){
        if (($model = Comision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
