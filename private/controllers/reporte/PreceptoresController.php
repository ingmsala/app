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
use app\models\Novedadesparte;
use app\models\Parte;
use app\models\Preceptoria;
use app\models\Rolexuser;
use app\modules\curriculares\models\Aniolectivo;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

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
                'only' => ['index', 'preceptores', 'asistencia'],
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
                        'actions' => ['preceptores', 'asistencia'],   
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
                $dataProvider = $searchModel->getPreceptores();
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
                $array[$division->id][3] = $division->aula;
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
            
            $partes = Parte::find()
                        ->select(['fecha', 'count(id)'])
                        ->where(['year(fecha)' => date('Y')])
                        ->andWhere(['>=','fecha', '2021-04-09'])
                        ->having(['<', 'count(id)', 6])
                        ->groupBy(['fecha'])
                        ->all();
            
            $partes = ArrayHelper::map($partes, 'fecha', 'fecha');
            $partesfaltantes = '<ul>';
            $partesfaltantesvf = false;
            foreach ($partes as $fecha) {
                $partespreceptoria = Parte::find()
                            ->where(['fecha' => $fecha])
                            ->andWhere(['preceptoria' => $pre->id])
                            ->count();
                if($partespreceptoria==0){
                    $partesfaltantes .= '<li>'.Yii::$app->formatter->asDate($fecha, 'dd/MM/yyyy').'</li>';
                    $partesfaltantesvf = true;
                }
            }
            $partesfaltantes .= '</ul>';
            
            if($partesfaltantesvf){
                Yii::$app->session->setFlash('warning', "Se encuentran pendientes de creación los partes en las siguientes fechas: <br><br>".$partesfaltantes);
            }
            
           



	        return $this->render('preceptores', 
	        [
                
	            'provider' => $provider,
	            'preceptores' => $preceptores,
                
	        ]);
	    }

    public function actionAsistencia($p=0, $a=0){

        $role = Rolexuser::find()
                        ->where(['user' => Yii::$app->user->identity->id])
                        ->andWhere(['role' => Globales::US_PRECEPTORIA])
                        ->one();

        $al = Aniolectivo::find()->where(['activo' => 1])->one()->nombre;

        $preceptoria = Preceptoria::find()->where(['nombre' => $role->subrole])->one()->id;
        
        if(Yii::$app->user->identity->role == Globales::US_SUPER){
            $al = $a;
            $preceptoria = $p;
        }
        if($p == 86)
            $novedades = Novedadesparte::find()
                    ->joinWith(['parte0'])
                    ->where(['tiponovedad' => 9])
                    ->andWhere(['year(parte.fecha)' => $al])
                    ->orderBy('parte.fecha')
                    ->all();
        else
        $novedades = Novedadesparte::find()
                    ->joinWith(['parte0'])
                    ->where(['tiponovedad' => 9])
                    ->andWhere(['parte.preceptoria' => $preceptoria])
                    ->andWhere(['year(parte.fecha)' => $al])
                    ->orderBy('parte.fecha')
                    ->all();
        
        $partes = ArrayHelper::map($novedades, 'parte',function($model){
            return $model->parte0->fecha;
        });

        

        if($p == 86)
        $nombramiento = Nombramiento::find()
        ->joinWith(['agente0', 'division0'])
        ->where(['cargo' => Globales::CARGO_PREC])
        ->andWhere(['revista' => 1])
        ->andWhere(['<=', 'division', 53])
        ->orderBy('agente.apellido, agente.nombre')
        ->all();
        else
         $nombramiento = Nombramiento::find()
        ->joinWith(['agente0', 'division0'])
        ->where(['cargo' => Globales::CARGO_PREC])
        ->andWhere(['division.preceptoria' => $preceptoria])
        ->andWhere(['revista' => 1])
        ->orderBy('agente.apellido, agente.nombre')
        ->all();

        //return var_dump($nombramiento);
        $preceptores = [];
        $preceptores = ArrayHelper::map($nombramiento, 'agente',function($model){
            return $model->agente0->nombreCompleto;
        });


        $preceptores += ArrayHelper::map($novedades, 'agente',function($model){
            return $model->agente0->nombreCompleto;
        });

        //return var_dump($preceptores);

        $datacolumn = [];
        $datacolumn['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $datacolumn['columns'][] =[
                        'label' => 'Preceptor/a',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        //'attribute' => '999',
                        'value' => function($model){
                            return $model['preceptor'];
                            
                        }
                    ];
        $datacolumn['columns'][] =[
                    'label' => 'Total',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'format' => 'raw',
                    //'attribute' => '999',
                    'value' => function($model){
                        return $model['total'];
                        
                    }
                ];

        //$preceptores = Preceptoria::findOne($preceptoria)->preceptores;
        $array = [];
            
        foreach ($preceptores as $agenteid => $preceptor) {
            $array[$agenteid]['agenteid'] = $agenteid;
            
            $array[$agenteid]['preceptor'] = $preceptor;

            $array[$agenteid]['total'] = 0;
            

        }
        
        foreach ($partes as $parteid => $parte) {
            $datacolumn['columns'][] =  [
                'class' => 'kartik\grid\BooleanColumn',
                'header' => Yii::$app->formatter->asDate($parte, 'dd/MM'),
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'trueLabel' => ' ',
                'trueIcon' => '<b><span class="text-success">✓</span></b>',
                'format' => 'raw',
                'attribute' => $parteid
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ];
            
        }

        

        foreach ($novedades as $novedadx) {
            $array[$novedadx->agente][$novedadx->parte] = true;
            $array[$novedadx->agente]['total'] = $array[$novedadx->agente]['total'] + 1;
        }

        
           
        usort($array, function($b, $a) {
            return $a['total'] - $b['total'];
        });
        
        
        //return var_dump($array);
        $provider = new ArrayDataProvider([
            'allModels' => $array,
            'pagination' => false,
            
        ]);

        return $this->render('asistencia', 
	        [
                
	            'provider' => $provider,
	            'datacolumn' => $datacolumn,
	            
                
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
