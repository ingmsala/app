<?php

namespace app\modules\optativas\controllers\autogestion;

use yii\web\Controller;
use Yii;use yii\filters\AccessControl;
use app\modules\optativas\models\Alumno;
use app\modules\optativas\models\Comision;
use app\modules\optativas\models\ClaseSearch;
use app\modules\optativas\models\MatriculaSearch;
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
                                $key1 = isset($_SESSION['dni']);
                                if (Alumno::find()->where(['dni' => $_SESSION['dni']])->one() != null)
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
        $dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : 0;

        $comisionesalumno= Comision::find()
                        ->joinWith(['matriculas', 'matriculas.alumno0'])
                        ->select('comision.id')
                        ->where(['alumno.dni' =>$dni])
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