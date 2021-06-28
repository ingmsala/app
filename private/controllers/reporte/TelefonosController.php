<?php

namespace app\controllers\reporte;

use Yii;

use app\models\AgenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use yii\data\ArrayDataProvider;

class TelefonosController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_DIRECCION]);
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

 	public function actionDocentes()
	    {
        $searchModel = new AgenteSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('docentes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        
        



}
