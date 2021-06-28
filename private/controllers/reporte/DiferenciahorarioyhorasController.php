<?php

namespace app\controllers\reporte;

use Yii;

use app\models\Catedra;
use app\models\CatedraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Horario;
use app\modules\curriculares\models\Aniolectivo;

class DiferenciahorarioyhorasController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_REGENCIA]);
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
            $model = new Catedra();

            if (Yii::$app->request->post()) {
                $searchModel = new CatedraSearch();
	            $dataProvider = $searchModel->diferenciacatedrasyhoras(Yii::$app->request->post()['Catedra']['aniolectivo']);
            }else{
                $searchModel = new CatedraSearch();
	            $dataProvider = $searchModel->diferenciacatedrasyhoras(0);
            }

            if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
                $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
            }
	        
            	        

	        return $this->render('index', 
	        [
                'model' => $model,
                'anios' => $anios,
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                
	        ]);
	    }

	
	protected function findModel($id)
    {
        if (($model = Catedra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
