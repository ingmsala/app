<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\Matricula;
use app\modules\optativas\models\MatriculaSearch;
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
                ->where(['alumno.dni' => $model->dni])
                ->andWhere(['matricula.estadomatricula' => 3])
                ->all();
            
            if ($matriculas != null){
                $model = Alumno::find()->where(['dni' => $model->dni])->one();
                $searchModel = new MatriculaSearch();
                $dataProvider = $searchModel->matriculasxalumno($model->dni);

                
                $matriculas = ArrayHelper::toArray($matriculas, [
                    'app\modules\optativas\models\Matricula' => [
                        'id',
                        'year' => function ($model) {
                            return $model->comision0->optativa0->aniolectivo0->nombre;
                         },
                        'optativa' => function ($model) {
                            return $model->comision0->optativa0->actividad0->nombre;
                         }
                    ],
                ]);

                $lista = '<ul>';
                foreach ($matriculas as $matricula) {
                    $lista .= '<li>'.$matricula['year'].' - '.$matricula['optativa'].'</li>';
                }
                $lista .= '<ul>';

                /*'<ul>'.
                '<li></li>'.
                '</ul>'*/
                return $this->render('index',[
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'lista' =>$lista,
                ]);
                
            }else{
                $model->dni = null;

                Yii::$app->session->setFlash('error', "El documento no corresponde a un alumno con optativas cursadas");
                return $this->redirect(['index']);
            }

           
        }
        return $this->render('index',[
                    'model' => $model,
        ]);
    }

   
}