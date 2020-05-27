<?php

namespace app\modules\curriculares\controllers\autogestion;

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
                                $key1 = Yii::$app->session->has('dni');
                                if (Alumno::find()->where(['dni' => Yii::$app->session->get('dni')])->one() != null)
                                    $key2 = true;
                                else
                                    $key2 = false;
                                if ($key1 and $key2)
                                    return true;
                                else
                                    return $this->redirect(['/curriculares/autogestion/inicio']);
                            }catch(\Exception $exception){
                                return $this->redirect(['/curriculares/autogestion/inicio']);
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
        
        $comision = Matricula::find()
                ->joinWith(['alumno0'])
                ->where(['matricula.id' => $id])
                ->andWhere(['alumno.dni' => $_SESSION['dni']])->one()->comision;
        $this->layout = 'mainautogestion';
        
        $searchModelInasistencias  = new InasistenciaSearch();
        $dataProviderInasistencias = $searchModelInasistencias->providerinasistenciasxalumno($id);

        $clasescomision = Clase::find()
                            ->where(['comision' => $comision])
                            ->where(['BETWEEN', 'fecha', date('Y-m-d', strtotime("+0 days")), date('Y-m-d', strtotime("+0 days"))])
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

        $ids = ArrayHelper::getColumn($listClasescomision, 0);
            $echodiv='';
            $i=0;
            foreach ($listClasescomision as $key => $value) {

                if($value == "P"){
                    $paneltype = 'success';
                    $prt = $value;
                }
                elseif ($value == "A"){
                    $paneltype = 'danger';
                    $prt = '<b>'.$value.'</b>';
                }
                else
                    break;
                $echodiv .= '<div class="col-md-2 col-lg-2 col-sm-2 col-lx-2">';
                $echodiv .= '<div class="panel panel-'.$paneltype.'" style="height: 12vh; margin:2px">';
                $echodiv .= '<div class="panel-heading" style="height: 5vh;">'.'<center>'.$key.'</center>'.'</div>';
                $echodiv .= '<div class="panel-body"><span class="align-top">';
                //$echodiv .= Html::checkbox("scripts", $sel, ['label' => 'Se Ausentó', 'value' => $matricula["id"]]);
                $echodiv .= '<center>'.$prt.'</center>';
                $echodiv .= '</span></div>
                                </div>
                              </div>';
                $i=$i+1;
            }

        
        $searchModelSeguimientos  = new SeguimientoSearch();
        $dataProviderSeguimientos = $searchModelSeguimientos->seguimientosdelalumno($id);


        return $this->render('index', [
            'dataProviderInasistencias' => $dataProviderInasistencias,
            'listClasescomision' => $listClasescomision,
            'dataProviderSeguimientos' => $dataProviderSeguimientos,
            'model' => $this->findModel($id),
            'echodiv' => $echodiv,
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
