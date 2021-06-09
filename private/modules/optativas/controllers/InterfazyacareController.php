<?php

namespace app\modules\optativas\controllers;

use app\config\Globales;
use Yii;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\MatriculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * CalificacionController implements the CRUD actions for Calificacion model.
 */
class InterfazyacareController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DESPACHO]);
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
     * Lists all Calificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = 'main';
        $model = new Alumno();

      
        if ($model->load(Yii::$app->request->post())) {

            $matriculas = Matricula::find()
                ->joinWith(['alumno0'])
                ->where(['alumno.documento' => $model->documento])
                //->andWhere(['matricula.estadomatricula' => 3])
                ->all();
            
            if ($matriculas != null){
                $model = Alumno::find()->where(['documento' => $model->documento])->one();
                $searchModel = new MatriculaSearch();
                $dataProvider = $searchModel->matriculasxalumno($model->documento, 99);

                
                /*$matriculas = ArrayHelper::toArray($matriculas, [
                    'app\modules\optativas\models\Matricula' => [
                        'id',
                        'aniolectivo' => function ($model) {
                            return $model->comision0->espaciocurricular0->aniolectivo0->nombre;
                         },
                        'optativa' => function ($model) {
                            return $model->comision0->espaciocurricular0->actividad0->nombre;
                         }
                    ],
                ]);*/

                /*$lista = '<ul>';
                foreach ($matriculas as $matricula) {
                    $lista .= '<li> - '.$matricula['optativa'].'</li>';
                }
                $lista .= '<ul>';*/

                
                return $this->render('index',[
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    
                ]);
                
            }else{
                $model->documento = null;

                Yii::$app->session->setFlash('error', "El documento no corresponde a un alumno con optativas cursadas");
                return $this->redirect(['index']);
            }

           
        }
        return $this->render('index',[
                    'model' => $model,
        ]);
    }

   
}