<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Detalleparte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

class DistribuciondediasyhorasController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);;
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

 	public function actionIndex($mes=0, $anio=0, $turno=0)
	    {  
            isset($_GET['anio']) ? $anio = $_GET['anio'] : '';
            isset($_GET['mes']) ? $mes = $_GET['mes'] : '';
            isset($_GET['turno']) ? $turno = $_GET['turno'] : '';
            ($anio == '') ? $anio = 0 : '';
            ($mes == '') ? $mes = 0 : '';
            ($turno == '') ? $turno = 0 : '';
	        $searchModel = new DetalleparteSearch();
            $dataProvider = $searchModel->providerdistribuciondediasyhoras($mes, $anio, $turno);

            $data =  [
                [0, 0, 0], [0, 1, 0], [0, 2, 0], [0, 3, 0], [0, 4, 0], [0, 5, 0], [0, 6, 0], [0, 7, 0], [0, 8, 0],
                [1, 0, 0], [1, 1, 0], [1, 2, 0], [1, 3, 0], [1, 4, 0], [1, 5, 0], [1, 6, 0], [1, 7, 0], [1, 8, 0],
                [2, 0, 0], [2, 1, 0], [2, 2, 0], [2, 3, 0], [2, 4, 0], [2, 5, 0], [2, 6, 0], [2, 7, 0], [2, 8, 0],
                [3, 0, 0], [3, 1, 0], [3, 2, 0], [3, 3, 0], [3, 4, 0], [3, 5, 0], [3, 6, 0], [3, 7, 0], [3, 8, 0],
                [4, 0, 0], [4, 1, 0], [4, 2, 0], [4, 3, 0], [4, 4, 0], [4, 5, 0], [4, 6, 0], [4, 7, 0], [4, 8, 0],
                [5, 0, 0], [5, 1, 0], [5, 2, 0], [5, 3, 0], [5, 4, 0], [5, 5, 0], [5, 6, 0], [5, 7, 0], [5, 8, 0],
                [6, 0, 0], [6, 1, 0], [6, 2, 0], [6, 3, 0], [6, 4, 0], [6, 5, 0], [6, 6, 0], [6, 7, 0], [6, 8, 0],
            ];

            foreach ($dataProvider->models as $fila) {
                
                $data[intval($fila['dia'])*9+8-intval($fila['horas'])] = [intval($fila['dia']), 8-intval($fila['horas']),intval($fila['faltas'])];
               
            }
            
	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'mes' => $mes,
                'anio' => $anio,
                'turno' => $turno,
                'data' => $data,
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
