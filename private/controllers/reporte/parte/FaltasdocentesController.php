<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use app\models\DetalleparteSearch;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;

class FaltasdocentesController extends \yii\web\Controller
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

 	public function actionIndex($mes = 0, $anio = 0)
	    {
	        $searchModel = new DetalleparteSearch();
	        $dataProvider = $searchModel->providerfaltasdocentes($mes, $anio);

	        
	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'anio' => $anio,
                'mes' => $mes,
	        ]);
	    }

	public function actionView($mes = 0, $anio = 0, $id)
    {
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerfaltasdocentesview($mes, $anio, $id);
 
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'anio' => $anio,
            'mes' => $mes,
        ]);
    }

	protected function findModel($id)
    {
        if (($model = Docente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
