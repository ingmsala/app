<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Agente;
use app\models\Actividad;
use app\models\AgenteSearch;
use app\models\DetallecatedraSearch;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Genero;
use yii\filters\AccessControl;
use app\config\Globales;

class HorasmateriaxcatedraController extends \yii\web\Controller
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
	        $searchModel = new DetallecatedraSearch();
	        $dataProvider = $searchModel->horasXMateriaXCatedra(Yii::$app->request->queryParams);
            $model = new Actividad();
            $param = Yii::$app->request->queryParams;
            if(isset($param['Actividad']['id']))
            $model->id = $param['Actividad']['id'];
	        

	        return $this->render('index', 
	        [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'actividades' => Actividad::find()->orderBy('nombre')->all(),
                'model' => $model,
                'param' => $param,
	        ]);
	    }

	public function actionView($id)
    {
        $searchModel = new DetallecatedraSearch();
        $dataProvider = $searchModel->providerDocentesxActividad($id);
        
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

	protected function findModel($id)
    {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
