<?php

namespace app\modules\curriculares\controllers\autogestion;

use yii\web\Controller;
use Yii;use yii\filters\AccessControl;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\MatriculaSearch;


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
                                $key1 = Yii::$app->session->has('documento');
                                if (Alumno::find()->where(['documento' => Yii::$app->session->get('documento')])->one() != null)
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
            
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        
    	$this->layout = 'vacio';
        $model = new Alumno();
        Yii::$app->session->remove('documento');
        if ($model->load(Yii::$app->request->post())) {

            
            if (Alumno::find()->where(['documento' => $model->documento])->one() != null){
                Yii::$app->session->set('documento', $model->documento);
                return $this->redirect(['/curriculares/autogestion/agenda/index']);
            }else{
                $model->documento = null;
                Yii::$app->session->setFlash('error', "El documento no corresponde a un estudiante con espacios curriculares cursados o que esté en condiciones de preinscribirse a un espacio.");
            }
        }

        return $this->render('index',[
            'model' => $model,
        ]);
    }

    public function actionView()
    {
        
         $documento = isset($_SESSION['documento']) ? $_SESSION['documento'] : 0;
        if($documento == 0){
            return $this->redirect(['index']);
        }
        $this->layout = 'mainautogestion';
        $documento = isset($_SESSION['documento']) ? $_SESSION['documento'] : 0;
        $model = Alumno::find()
                    ->where(['documento' => $documento])->one();

        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->matriculasxalumno($documento);

        return $this->render('view',[
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    
}