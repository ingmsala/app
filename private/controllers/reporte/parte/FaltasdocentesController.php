<?php

namespace app\controllers\reporte\parte;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use app\models\DetalleparteSearch;
use app\models\Detalleparte;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;

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
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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
	        $dataProvider = $searchModel->providerfaltasdocentes($mes, $anio, $docente);
            $model = new Detalleparte();
            $param = Yii::$app->request->queryParams;
            	        
	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'anio' => $anio,
                'mes' => $mes,
                'docente' => $docente,
                'model' => $model,
                'param' => $param,
                'docentes' => Docente::find()->orderBy('apellido, nombre')->all(),
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
