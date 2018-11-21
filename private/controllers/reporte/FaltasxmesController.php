<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Detalleparte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class FaltasxmesController extends \yii\web\Controller
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

 	public function actionIndex($mes=11)
	    {  

	        $searchModel = new DetalleparteSearch();
            $dataProvider = $searchModel->providerxmes($mes);

	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	        ]);
	    }

	public function actionView($id)
    {
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerxmes($id);
        //$horasCatedraACobrar = $searchModel->cantidadHorasACobrarXDocente($id);
        //$horasCatedraSinCobrar = $searchModel->cantidadHorasConLicenciaSinGoceXDocente($id);

        //$searchModelNombram = new NombramientoSearch();
        //$horasCatedraACobrarNom = $searchModelNombram->cantidadHorasACobrarXDocente($id);
        //$horasCatedraSinCobrarNom = $searchModelNombram->cantidadHorasConLicenciaSinGoceXDocente($id);

        //$searchModelNombramientos = new NombramientoSearch();
        //$dataProviderNombramientos = $searchModelNombramientos->searchByDocente($id);



        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            /*'searchModelNombramientos' => $searchModelNombramientos,
            'dataProviderNombramientos' => $dataProviderNombramientos,

            'horasCatedraACobrar' => $horasCatedraACobrar,
            'horasCatedraSinCobrar' => $horasCatedraSinCobrar,

            'horasCatedraACobrarNom' => $horasCatedraACobrarNom,
            'horasCatedraSinCobrarNom' => $horasCatedraSinCobrarNom,*/
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
