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

class FaltasxmesesxturnoController extends \yii\web\Controller
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
            $dataProvider = $searchModel->providerxanioxturno($anio);
            
            $meses = ArrayHelper::getColumn($dataProvider->models, 'meses');
            $mesesesp = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',];
            
            $mesespok = [];
            foreach ($meses as $mes) {
                $mesespok[] = $mesesesp[$mes];
            }
            
            
            return $this->render('index', 
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'anio' => $anio,
                'mes' => 0,
                'mesespok' => $mesespok,
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
