<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Agente;
use app\models\AgenteSearch;
use app\models\DetalleparteSearch;
use app\models\Detalleparte;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;
use app\modules\curriculares\models\Aniolectivo;

class EstadoinasistenciasdocentesController extends \yii\web\Controller
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

 	public function actionIndex($mes = 0, $anio = 1, $docente = 0)
	    {
	        $searchModel = new DetalleparteSearch();
	        $dataProvider = $searchModel->estadoinasistenciaXdocente($mes, $anio, $docente);
            $model = new Detalleparte();
            $param = Yii::$app->request->queryParams;
            $years = Aniolectivo::find()->all();
            //$dataProvider->setPagination(['pageSize' => 100]);
	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'anio' => $anio,
                'mes' => $mes,
                'agente' => $docente,
                'model' => $model,
                'param' => $param,
                'docentes' => Agente::find()->orderBy('apellido, nombre')->all(),
                'years' => $years,
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
        if (($model = Agente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
