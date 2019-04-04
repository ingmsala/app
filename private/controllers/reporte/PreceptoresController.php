<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Nombramiento;
use app\models\Propuesta;
use app\models\Condicion;
use app\models\Revista;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;


class PreceptoresController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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
	        $searchModel = new NombramientoSearch();
	        $dataProvider = $searchModel->getPreceptores();
            $model = new Nombramiento();

	        

	        return $this->render('index', 
	        [
                'model' => $model,
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'propuestas' => Propuesta::find()->all(),
                'condiciones' => Condicion::find()->all(),
                'revistas' => Revista::find()->all(),
	        ]);
	    }

	
	protected function findModel($id)
    {
        if (($model = Nombramiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
