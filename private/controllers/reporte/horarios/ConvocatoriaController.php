<?php

namespace app\controllers\reporte\horarios;

use Yii;
use app\config\Globales;
use app\models\Catedra;
use app\models\Horario;
use app\models\HorarioSearch;
use app\modules\curriculares\models\Aniolectivo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HorarioController implements the CRUD actions for Horario model.
 */
class ConvocatoriaController extends Controller
{

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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA]);
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

public function actionIndex()
    {
        $anios = Aniolectivo::find()->all();
        $modelCatedra = new Catedra();

        if (Yii::$app->request->post()) {
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getConvocatoria(Yii::$app->request->post()['Catedra']['aniolectivo']);
        }else{
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getConvocatoria(0);
        }

        if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
            $modelCatedra->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
        }

        
        return $this->render('index', [
            'modelCatedra' => $modelCatedra,
            'anios' => $anios,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}