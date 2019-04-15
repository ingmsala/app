<?php

namespace app\modules\optativas\controllers\autogestion;

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
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $key1 = isset($_SESSION['dni']);
                                if (Alumno::find()->where(['dni' => $_SESSION['dni']])->one() != null)
                                    $key2 = true;
                                else
                                    $key2 = false;
                                if ($key1 and $key2)
                                    return true;
                                else
                                    return $this->redirect(['autogestion']);
                            }catch(\Exception $exception){
                                return $this->redirect(['autogestion']);
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

    public function actionIndex($id)
    {
        Yii::$app->session->setFlash('error', "No está habilitada la sección a la que intenta ingresar. <b>Próximamente</b> estará disponible");
     
            
        return $this->redirect(['/optativas/autogestion/agenda/index']);
        $comision = Matricula::find()
                ->joinWith(['alumno0'])
                ->where(['matricula.id' => $id])
                ->andWhere(['alumno.dni' => $_SESSION['dni']])->one()->comision;
        $this->layout = 'mainautogestion';
        
        $searchModelInasistencias  = new InasistenciaSearch();
        $dataProviderInasistencias = $searchModelInasistencias->providerinasistenciasxalumno($id);

        $clasescomision = Clase::find()
                            ->where(['comision' => $comision])
                            ->orderBy('fecha ASC')
                            ->all();

        $listClasescomision=ArrayHelper::map($clasescomision,
                function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM');
                    
                },
                function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fecha = date_create($model->fecha);
                    $hoy = new DateTime("now");
                    $interval = $fecha->diff($hoy);
                    $signo = $interval->format('%R');
                    //$interval = $interval->format('%a');
                    //$interval = intval($interval);
                    //return $signo;
                    if ($signo == '+')
                        return "P";
                    else
                        return '';
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
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fecha = date_create($model->clase0->fecha);
                    $hoy = new DateTime("now");
                    $interval = $fecha->diff($hoy);
                    $signo = $interval->format('%R');

                    if ($signo == '+')
                        return "A";
                    else
                        return '';
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


        return $this->render('index', [
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
