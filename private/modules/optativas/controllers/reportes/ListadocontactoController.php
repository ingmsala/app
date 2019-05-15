<?php

namespace app\modules\optativas\controllers\reportes;

use Yii;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\Comision;
use app\modules\optativas\models\Clase;
use app\modules\optativas\models\Optativa;
use app\modules\optativas\models\InasistenciaSearch;
use app\modules\optativas\models\SeguimientoSearch;
use app\modules\optativas\models\Inasistencia;
use app\modules\optativas\models\Estadomatricula;
use app\modules\optativas\models\MatriculaSearch;
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
class ListadocontactoController extends \yii\web\Controller
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
                                return in_array (Yii::$app->user->identity->role, [1,3,6,9,12,14]);
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
                $com = $this->findModel($comision);
                $optnom = $com->optativa0->aniolectivo0->nombre.' - '.$com->optativa0->actividad0->nombre.' <br/> Comisión: '.$com->nombre;
                   
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