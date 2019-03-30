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


/**
 * MatriculaController implements the CRUD actions for Matricula model.
 */
class FichadelalumnoController extends \yii\web\Controller
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
     * Lists all Matricula models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $searchModel = new MatriculaSearch();
        $comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        $dataProvider = $searchModel->alumnosxcomision($comision);
           
        return $this->render('index', [
            
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,

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
        $this->layout = 'main';
        $comision = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        $searchModelInasistencias  = new InasistenciaSearch();
        $dataProviderInasistencias = $searchModelInasistencias->providerinasistenciasxalumno($id);

        $clasescomision = Clase::find()
                            ->where(['comision' => $comision])
                            ->all();

        $listClasescomision=ArrayHelper::map($clasescomision,
                function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM');
                    
                },
                function($model){
                    return "P";
                }
        );

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
                    return "A";
                });

        $listClasescomision = array_merge($listClasescomision, $listFaltasdelalumno);

        $data = [
            $listClasescomision,
            
        ];

        $dataProviderInasistencias = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            
        ]);

        
        $searchModelSeguimientos  = new SeguimientoSearch();
        $dataProviderSeguimientos = $searchModelSeguimientos->seguimientosdelalumno($id);


        return $this->render('view', [
            'dataProviderInasistencias' => $dataProviderInasistencias,
            'listClasescomision' => $listClasescomision,
            'dataProviderSeguimientos' => $dataProviderSeguimientos,
            'model' => $this->findModel($id),
        ]);
        
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
