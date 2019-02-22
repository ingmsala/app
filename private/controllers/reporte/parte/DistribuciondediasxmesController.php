<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Detalleparte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DistribuciondediasxmesController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->username, ['msala', 'secretaria', 'consulta']);
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

 	public function actionIndex($mes=0, $anio=0)
	    {  
            isset($_GET['anio']) ? $anio = $_GET['anio'] : '';
            isset($_GET['mes']) ? $mes = $_GET['mes'] : '';
            ($anio == '') ? $anio = 0 : '';
            ($mes == '') ? $mes = 0 : '';
	        $searchModel = new DetalleparteSearch();
            $dataProvider = $searchModel->providerdistribuciondediasxmes($mes, $anio);
            
	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'mes' => $mes,
                'anio' => $anio,
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
