<?php

namespace app\controllers\reporte\relevamiento;

use Yii;


use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Detallecatedra;
use app\models\Nombramiento;
use yii\data\ActiveDataProvider;

class CargosdocentesController extends \yii\web\Controller
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

 	public function actionIndex()
	    {
            
            $director = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 211])
                            ->andWhere(['revista' => 1])
                            ->groupBy(['condicion.nombre'])
                            ;

            $regentes = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 202])
                            ->andWhere(['revista' => 1])
                            ->groupBy(['condicion.nombre'])
                            ;
            $vices = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 201])
                            ->andWhere(['revista' => 1])
                            ->groupBy(['condicion.nombre'])
                            ;
            $secretarios = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 233])
                            ->andWhere(['revista' => 1])
                            ->groupBy(['condicion.nombre'])
                            ;
            
            $jefes = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 223])
                            ->andWhere(['revista' => 1])
                            ->andWhere(['division' => 61])
                            ->groupBy(['condicion.nombre'])
                            ;

            $preceptores = Nombramiento::find()
                            ->select('condicion.nombre, count(nombramiento.id) as cantidad')
                            ->joinWith(['condicion0', 'cargo0'])
                            ->where(['nombramiento.cargo' => 227])
                            ->andWhere(['revista' => 1])
                            ->andWhere(['<>', 'division', 62])
                            ->groupBy(['condicion.nombre'])
                            ;
            //$array = [];

            $director = new ActiveDataProvider([
                'query' => $director,
            ]);
            $regentes = new ActiveDataProvider([
                'query' => $regentes,
            ]);
            $vices = new ActiveDataProvider([
                'query' => $vices,
            ]);
            $secretarios = new ActiveDataProvider([
                'query' => $secretarios,
            ]);
            $jefes = new ActiveDataProvider([
                'query' => $jefes,
            ]);
            $preceptores = new ActiveDataProvider([
                'query' => $preceptores,
            ]);
            
            return $this->render('index', 
	        [
                'director' => $director,
                'regentes' => $regentes,
                'vices' => $vices,
                'secretarios' => $secretarios,
                'jefes' => $jefes,
                'preceptores' => $preceptores,
                
	            
                
	        ]);

        }

}