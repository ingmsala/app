<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Detalleparte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class FaltasxanioxturnototalController extends \yii\web\Controller
{


	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        
                        'allow' => true,
                        'roles' => ['@'],
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

 	public function actionIndex($anio=0)
	    {  
            isset($_GET['anio']) ? $anio = $_GET['anio'] : '';
            ($anio == '') ? $anio = 0 : '';
            
            
            $searchModel = new DetalleparteSearch();
            $dataProvider = $searchModel->providerxanioxturnototal($anio);
            
                        
            
            return $this->render('index', 
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'anio' => $anio,
               
                
            ]);
        }

    
	

	protected function findModel($id)
    {
        if (($model = Detalleparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
