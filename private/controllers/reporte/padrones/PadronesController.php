<?php

namespace app\controllers\reporte\padrones;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Agente;
use app\models\Cargo;
use app\models\Nombramiento;
use app\models\NombramientoSearch;
use app\models\AgenteSearch;
use app\models\DetallecatedraSearch;
use app\config\Globales;

class PadronesController extends \yii\web\Controller
{


	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'preceptores', 'jefespreceptor', 'docentes', 'otrosdocentes', 'getall'],
                'rules' => [
                    [
                        'actions' => ['index', 'preceptores', 'jefespreceptor', 'docentes', 'otrosdocentes', 'getall'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_JUNTA]);
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

 	public function actionIndex(){  
        try{
            $searchModel = new NombramientoSearch();
            $searchModel2 = new DetallecatedraSearch();
            /*$cantidadjefessecundario = $searchModel->getCantidadJefes(1);
            $cantidadjefespregrado = $searchModel->getCantidadJefes(2);
            $cantidadpreceptoressecundario = $searchModel->getCantidadPreceptores(1);
            $cantidadpreceptorespregrado = $searchModel->getCantidadPreceptores(2);
            $cantidadotrosdocentessec = $searchModel->getCantidadOtrosDocentes(1, Globales::PADRON_OTROSDOC);
            $cantidadotrosdocentespre = $searchModel->getCantidadOtrosDocentes(2, Globales::PADRON_OTROSDOC);
            $cantidaddocentessecundario = $searchModel2->getCantidadDocentes(1);
            $cantidaddocentespregrado = $searchModel2->getCantidadDocentes(2);*/

            /*$searchModelDoc = new AgenteSearch();
            $dataProviderDoc = $searchModelDoc->getPadronsumarizado();
            $cantidadtotal = $dataProviderDoc->getTotalCount();*/

                      
            return $this->render('index',[
                'cantidadjefessecundario' => "",
                'cantidadjefespregrado' => "",
                'cantidadpreceptoressecundario' => "",
                'cantidadpreceptorespregrado' => "",
                'cantidadotrosdocentessec' => "",
                'cantidadotrosdocentespre' => "",
                'cantidaddocentessecundario' => "",
                'cantidaddocentespregrado' => "",
                'cantidadtotal' => "",
            ]);
        }catch(\Exception $exception){
            //Yii::$app->session->setFlash('error', $exception);
            //return $this->render('index',[
            //'model' => $model,
            return var_dump($exception);
        //]);
            
	    }
        }

    private function getPreceptores($prop){
        if($prop ==1){
            return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                
                ->orderBy('agente.apellido, agente.nombre')->all();
            }else{
                return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    
                ])
                
                ->orderBy('agente.apellido, agente.nombre')->all();
            }
    }

    private function getJefes($prop){
        return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                ->orderBy('agente.apellido, agente.nombre')->all();
    }

    private function getJefesPre($prop){
        return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    
                ])
                
                ->orderBy('agente.apellido, agente.nombre')->all();
    }

    private function getAgentes($prop){
        return Agente::find()
                ->distinct()
                ->joinWith(['detallecatedras', 'detallecatedras.catedra0', 'detallecatedras.catedra0.division0'])
                ->where(['detallecatedra.activo' => 1])
                ->andWhere(['division.propuesta' => $prop])
                
                ->orderBy('agente.apellido, agente.nombre')->all();
    }

    private function getOtrosDocentes($prop){
        if($prop ==1){
             return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(true)
                ->andWhere(['in', 
                    'cargo', Globales::PADRON_OTROSDOC
                ])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                ->orderBy('agente.apellido, agente.nombre')->all();
        }else{
             return Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(true)
                ->andWhere(['in', 
                    'cargo', Globales::PADRON_OTROSDOC
                ])
                ->andWhere( 
                    ['division.propuesta' => $prop])
                ->orderBy('agente.apellido, agente.nombre')->all();
        }
       
    }

    public function actionPreceptores($prop){  
                      
            $searchModel = new NombramientoSearch();
            $dataProvider = $searchModel->getPadronPreceptores($prop);
            if($prop == 1)
                $propuesta = 'SECUNDARIO';
            if($prop == 2)
                $propuesta = 'PREGRADO';

            $jefessec = $this->getJefes(1);
            $jefespre = $this->getJefespre(2);
            $docsec = $this->getAgentes(1);
            $docpre = $this->getAgentes(2);
            $precsec = $this->getPreceptores(1);
            $precpre = $this->getPreceptores(2);
            $otrosdoc = $this->getOtrosDocentes(1);
            $otrosdocpre = $this->getOtrosDocentes(2);



            return $this->render('preceptores',[
                
                
                'dataProvider' => $dataProvider,
                'propuesta' => $propuesta,
                'jefessec' => $jefessec,
                'jefespre' => $jefespre,
                'docsec' => $docsec,
                'docpre' => $docpre,
                'precsec' => $precsec,
                'precpre' => $precpre,
                'otrosdoc' => $otrosdoc,
                'otrosdocpre' => $otrosdocpre,
            ]);
    }

    public function actionJefespreceptor($prop){  
                      
            $searchModel = new NombramientoSearch();
            $dataProvider = $searchModel->getPadronJefes($prop);
            if($prop == 1)
                $propuesta = 'SECUNDARIO';
            if($prop == 2)
                $propuesta = 'PREGRADO';

            $jefessec = $this->getJefes(1);
            $jefespre = $this->getJefespre(2);
            $docsec = $this->getAgentes(1);
            $docpre = $this->getAgentes(2);
            $precsec = $this->getPreceptores(1);
            $precpre = $this->getPreceptores(2);
            $otrosdoc = $this->getOtrosDocentes(1);
            $otrosdocpre = $this->getOtrosDocentes(2);

            return $this->render('jefespreceptor',[
                
                
                'dataProvider' => $dataProvider,
                'propuesta' => $propuesta,
                'jefessec' => $jefessec,
                'jefespre' => $jefespre,
                'docsec' => $docsec,
                'docpre' => $docpre,
                'precsec' => $precsec,
                'precpre' => $precpre,
                'otrosdoc' => $otrosdoc,
                'otrosdocpre' => $otrosdocpre,
            ]);
    }

    public function actionDocentes($prop){  
                      
            $searchModel = new DetallecatedraSearch();
            $dataProvider = $searchModel->getPadronDocente($prop);
            if($prop == 1)
                $propuesta = 'SECUNDARIO';
            if($prop == 2)
                $propuesta = 'PREGRADO';

            $jefessec = $this->getJefes(1);
            $jefespre = $this->getJefespre(2);
            $docsec = $this->getAgentes(1);
            $docpre = $this->getAgentes(2);
            $precsec = $this->getPreceptores(1);
            $precpre = $this->getPreceptores(2);
            $otrosdoc = $this->getOtrosDocentes(1);
            $otrosdocpre = $this->getOtrosDocentes(2);

            return $this->render('docentes',[
                                
                'dataProvider' => $dataProvider,
                'propuesta' => $propuesta,
                'jefessec' => $jefessec,
                'jefespre' => $jefespre,
                'docsec' => $docsec,
                'docpre' => $docpre,
                'precsec' => $precsec,
                'precpre' => $precpre,
                'otrosdoc' => $otrosdoc,
                'otrosdocpre' => $otrosdocpre,
            ]);
    }

    public function actionOtrosdocentes($prop){  

            $param = Yii::$app->request->queryParams;

            try{
                 $largo = count($param['Nombramiento']['cargo']);
             }catch(\Exception $exception){
                $largo = 0;
            }

            
            
            $cargos = Cargo::find()->all();
            $model = new Nombramiento();          
            
            if($prop == 1)
                $propuesta = 'SECUNDARIO';
            if($prop == 2)
                $propuesta = 'PREGRADO';

            $cargosseleccionados = [];
            if($largo<1){
                $cargosseleccionados = Globales::PADRON_OTROSDOC;
                $model->cargo = $cargosseleccionados;
            }else{
                if(isset($param['Nombramiento']['cargo']))
                    $cargosseleccionados = $param['Nombramiento']['cargo'];
                    $model->cargo = $param['Nombramiento']['cargo'];
            }

            $searchModel = new NombramientoSearch();
            $dataProvider = $searchModel->getPadronOtrosDocente($prop, $cargosseleccionados);

            $jefessec = $this->getJefes(1);
            $jefespre = $this->getJefespre(2);
            $docsec = $this->getAgentes(1);
            $docpre = $this->getAgentes(2);
            $precsec = $this->getPreceptores(1);
            $precpre = $this->getPreceptores(2);
            $otrosdoc = $this->getOtrosDocentes(1);
            $otrosdocpre = $this->getOtrosDocentes(2);

            return $this->render('otrosdocentes',[
                'model' => $model,
                'dataProvider' => $dataProvider,
                'propuesta' => $propuesta,
                'cargos' => $cargos,
                'prop' => $prop,
                'jefessec' => $jefessec,
                'jefespre' => $jefespre,
                'docsec' => $docsec,
                'docpre' => $docpre,
                'precsec' => $precsec,
                'precpre' => $precpre,
                'otrosdoc' => $otrosdoc,
                'otrosdocpre' => $otrosdocpre,
                
            ]);
    }

    public function actionGetall(){  
                      
            $searchModel = new AgenteSearch();
            $dataProvider = $searchModel->getPadronsumarizado();
            
            return $this->render('getall',[
                
                
                'dataProvider' => $dataProvider,
                
            ]);
    }

}