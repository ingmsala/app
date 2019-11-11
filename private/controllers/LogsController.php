<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CursoController implements the CRUD actions for Curso model.
 */
class LogsController extends Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Curso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $array = [];
        $array[0][0] = 'Horario a clases';
        $array[0][1] = 'readlog&tipo=1'; 
        $array[1][0] = 'Horario a trimestral';
        $array[1][1] = 'readlog&tipo=2'; 
        $array[2][0] = 'Horario a Coloquio';
        $array[2][1] = 'readlog&tipo=3';   
       $dataProvider = new ArrayDataProvider([
            'allModels' => $array,
            'pagination' => false,
            
            
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Curso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
}