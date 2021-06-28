<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Agente;
use app\models\AgenteSearch;
use app\models\DetallecatedraSearch;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;

class HorasdocentesController extends \yii\web\Controller
{


	/**
     * {@inheritdoc}
     */
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
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
	        $searchModel = new AgenteSearch();
	        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	        ]);
	    }

	public function actionView($id)
    {
        $searchModel = new DetallecatedraSearch();
        $dataProvider = $searchModel->providerxdocente($id, Globales::DOC_ACTIVOS);
        $dataProviderInactivos = $searchModel->providerxdocente($id, Globales::DOC_INACTIVOS);
        $horasCatedraACobrar = $searchModel->cantidadHorasACobrarXDocente($id);
        $horasCatedraSinCobrar = $searchModel->cantidadHorasConLicenciaSinGoceXDocente($id);

        $searchModelNombram = new NombramientoSearch();
        $horasCatedraACobrarNom = $searchModelNombram->cantidadHorasACobrarXDocente($id);
        $horasCatedraSinCobrarNom = $searchModelNombram->cantidadHorasConLicenciaSinGoceXDocente($id);

        $searchModelNombramientos = new NombramientoSearch();
        $dataProviderNombramientos = $searchModelNombramientos->searchByDocente($id);



        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderInactivos' => $dataProviderInactivos,
            'searchModelNombramientos' => $searchModelNombramientos,
            'dataProviderNombramientos' => $dataProviderNombramientos,

            'horasCatedraACobrar' => $horasCatedraACobrar,
            'horasCatedraSinCobrar' => $horasCatedraSinCobrar,

            'horasCatedraACobrarNom' => $horasCatedraACobrarNom,
            'horasCatedraSinCobrarNom' => $horasCatedraSinCobrarNom,
        ]);
    }

	protected function findModel($id)
    {
        if (($model = Agente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
