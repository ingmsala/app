<?php

namespace app\controllers\reporte;

use Yii;
use app\models\Nombramiento;
use app\models\Propuesta;
use app\models\Condicion;
use app\models\Revista;
use app\models\NombramientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Division;
use app\models\DivisionSearch;
use app\models\Preceptoria;
use app\models\Rolexuser;
use yii\data\ArrayDataProvider;

class PreceptoresController extends \yii\web\Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_CONSULTA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['preceptores'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA]);
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
            $searchModel = new NombramientoSearch();
            if(Yii::$app->user->identity->role == Globales::US_REGENCIA){
                $dataProvider = $searchModel->getPreceptores(0);
            }else{
                $dataProvider = $searchModel->getPreceptores();
            }
	        
            $model = new Nombramiento();

	        

	        return $this->render('index', 
	        [
                'model' => $model,
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
                'propuestas' => Propuesta::find()->all(),
                'condiciones' => Condicion::find()->all(),
                'revistas' => Revista::find()->all(),
	        ]);
        }
        
        public function actionPreceptores()
	    {
	        
            $preceptores = Nombramiento::find()
                ->where(['cargo' => Globales::CARGO_PREC])
                ->orderBy('division, revista')->all();

            //$pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();

            $role = Rolexuser::find()
                        ->where(['user' => Yii::$app->user->identity->id])
                        ->andWhere(['role' => Globales::US_PRECEPTORIA])
                        ->one();

            $pre = Preceptoria::find()->where(['nombre' => $role->subrole])->one();
            $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();

            $array = [];
            
            foreach ($divisiones as $division) {
                $array[$division->id][0] = $division->id;
                
                $array[$division->id][1] = $division->nombre;
                try {
                    $nombramiento = Nombramiento::find()
                    ->where(['cargo' => Globales::CARGO_PREC])
                    ->where(['division' => $division->id])
                    ->one();
                    $docente = $nombramiento->agente0->apellido.', '.$nombramiento->agente0->nombre;
                    $array[$division->id][999] = $nombramiento->id;
                } catch (\Throwable $th) {
                    $docente = '';
                    $array[$division->id][999] = 0;
                }
                
                $array[$division->id][2] = $docente;
            }

            $provider = new ArrayDataProvider([
                'allModels' => $array,
                
            ]);

	        return $this->render('preceptores', 
	        [
                
	            'provider' => $provider,
	            'preceptores' => $preceptores,
                
	        ]);
	    }

	
	protected function findModel($id)
    {
        if (($model = Nombramiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
