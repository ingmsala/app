<?php

namespace app\modules\optativas\controllers\autogestion;

use yii\web\Controller;
use Yii;use yii\filters\AccessControl;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\MatriculaSearch;


/**
 * Default controller for the `optativas` module
 */
class InicioController extends \yii\web\Controller
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
    	//$this->layout = 'mainautogestion';
        $model = new Alumno();
        Yii::$app->session->destroy();
        if ($model->load(Yii::$app->request->post())) {

            
            if (Alumno::find()->where(['dni' => $model->dni])->one() != null){
                $this->actionSetsession($model->dni);
                return $this->redirect(['view']);
            }else{
                $model->dni = null;
                Yii::$app->session->setFlash('error', "El documento no corresponde a un alumno con optativas cursadas o que esté en condiciones de preinscribirse a un espacio.");
            }
        }

        return $this->render('index',[
            'model' => $model,
        ]);
    }

    public function actionView()
    {
         $dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : 0;
        if($dni == 0){
            return $this->redirect(['index']);
        }
        $this->layout = 'mainautogestion';
        $dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : 0;
        $model = Alumno::find()
                    ->where(['dni' => $dni])->one();

        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->matriculasxalumno($dni);

        return $this->render('view',[
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSetsession($dni)
    {   

        $session = Yii::$app->session;
		$session->set('dni', $dni);
        return $dni;
    }
}