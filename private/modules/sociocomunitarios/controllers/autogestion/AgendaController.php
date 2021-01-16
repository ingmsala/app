<?php

namespace app\modules\optativas\controllers\autogestion;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\ClaseSearch;
use app\modules\curriculares\models\MatriculaSearch;
use yii\helpers\ArrayHelper;


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
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
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
        
        $this->layout = 'mainautogestion';
        $documento = isset($_SESSION['documento']) ? $_SESSION['documento'] : 0;
        $model = Alumno::find()
                    ->where(['documento' => $documento])->one();

        $searchModel = new MatriculaSearch();
        $dataProvider = $searchModel->matriculasxalumno($documento);

        return $this->render('index',[
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {

        $this->layout = 'mainautogestion';
        $documento = isset($_SESSION['documento']) ? $_SESSION['documento'] : 0;

        $comisionesalumno= Comision::find()
                        ->joinWith(['matriculas', 'matriculas.alumno0'])
                        ->select('comision.id')
                        ->where(['alumno.documento' =>$documento])
                        ->all();

        $comisionesalumno=ArrayHelper::map($comisionesalumno,'id','id');

        $comision = Comision::find()
                        ->where(['id' => $id])
                        ->one();

        if($comision != null){

            if(in_array($comision->id, $comisionesalumno)){
            $searchModel = new ClaseSearch();
                    $dataProvider = $searchModel->clasexalumno(Yii::$app->request->queryParams);
                    return $this->render('view', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'comision' => $comision,
                        

                ]);
            }
            
        
        }
        Yii::$app->session->setFlash('error', "No está matriculado en la comisión que intenta acceder");
            return $this->redirect(['/optativas/autogestion/agenda/index']);

        
    }

}