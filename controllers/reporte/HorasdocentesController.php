<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;

class HorasdocentesController extends \yii\web\Controller
{


	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
	        $searchModel = new DocenteSearch();
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
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
