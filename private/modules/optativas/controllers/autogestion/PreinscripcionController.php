<?php

namespace app\modules\optativas\controllers\autogestion;

use Yii;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\CalificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
        $this->layout = 'mainautogestion';

        
     Yii::$app->session->setFlash('error', "No existe un periodo de <b>Preinscripción</b> activo.");
     
             
        return $this->redirect(['/optativas/autogestion/agenda/index']);
    }

   
}
