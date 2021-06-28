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


class DiferenciahorarioController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_DIRECCION]);
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
            $searchModel = new CatedraSearch();
            $dataProviderRepetido = $searchModel->vigenterepetido();
            
            if($dataProviderRepetido->getCount()>0){
                return $this->render('vigenterepetido', 
                [
                    
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProviderRepetido,
                    
                ]);
            }

	        $dataProvider = $searchModel->diferenciacatedras();
            	        

	        return $this->render('index', 
	        [
                
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
