<?php

namespace app\modules\optativas\controllers\autogestion;

use yii\web\Controller;
use Yii;use yii\filters\AccessControl;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\ClaseSearch;
use app\modules\optativas\models\MatriculaSearch;


/**
 * Default controller for the `optativas` module
 */
class AgendaController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $key1 = isset($_SESSION['dni']);
                                if (Alumno::find()->where(['dni' => $_SESSION['dni']])->one() != null)
                                    $key2 = true;
                                else
                                    $key2 = false;
                                return ($key1 and $key2);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    
                ],
            ],
            
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()

    {
        
        $this->layout = 'mainautogestion';
        $dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : 0;
        $model = Alumno::find()
                    ->where(['dni' => $dni])->one();

        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->matriculasxalumno($dni);

        return $this->render('index',[
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {

        $this->layout = 'mainautogestion';
        $searchModel = new ClaseSearch();
        $dataProvider = $searchModel->clasexalumno(Yii::$app->request->queryParams);
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            

        ]);
    }

}