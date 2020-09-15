<?php

namespace app\modules\sociocomunitarios\controllers\reportes;

use Yii;
use app\modules\curriculares\models\Inasistencia;
use app\modules\curriculares\models\Aniolectivo;

use app\models\Division;

use app\modules\curriculares\models\SeguimientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;




/**
 * MatriculaController implements the CRUD actions for Matricula model.
 */
class SeguimientosController extends \yii\web\Controller
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
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14,20]);
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
     * Lists all Matricula models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->layout = 'main';
        $model = new Inasistencia();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;

        $params = Yii::$app->request->queryParams;

        if(isset($params['Inasistencia']['division']))
            $model->division = $params['Inasistencia']['division'];
        if(isset($params['Inasistencia']['aniolectivo']))
            $model->aniolectivo = $params['Inasistencia']['aniolectivo'];
        $searchModel = new SeguimientoSearch();
        $dataProvider = $searchModel->providerseguimientoxdivision($params, 2);
        $aniolectivos = Aniolectivo::find()->all();
        $divisiones = Division::find()->where(['<=', 'id', 53])->all();

                                   
        return $this->render('index', [

            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'aniolectivos' => $aniolectivos,
            'divisiones' => $divisiones,
            'param' => $params,
            

        ]);
            
        
        

    }

    
}