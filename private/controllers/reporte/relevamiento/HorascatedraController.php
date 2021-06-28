<?php

namespace app\controllers\reporte\relevamiento;

use Yii;


use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Detallecatedra;

class HorascatedraController extends \yii\web\Controller
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
            
            $horasCatedraSemanalesTitulares1 = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 1])
                                                ->andWhere(['<=', 'division.id', 8])
                                                ->andWhere(['in', 'detallecatedra.condicion', [1,2,3]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();

            $sumaHorasCatedraSemanalesTitulares1 = 0;

            foreach ($horasCatedraSemanalesTitulares1 as $horasCatedraSemanalesTitulares1ok) {
                $sumaHorasCatedraSemanalesTitulares1 = $sumaHorasCatedraSemanalesTitulares1 + $horasCatedraSemanalesTitulares1ok->hora;
            }

            $horasCatedraSemanalesInterinas1 = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 1])
                                                ->andWhere(['<=', 'division.id', 8])
                                                ->andWhere(['in', 'detallecatedra.condicion', [4]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesInterinas1 = 0;

            foreach ($horasCatedraSemanalesInterinas1 as $horasCatedraSemanalesInterinas1ok) {
                $sumaHorasCatedraSemanalesInterinas1 = $sumaHorasCatedraSemanalesInterinas1 + $horasCatedraSemanalesInterinas1ok->hora;
            }

            $horasCatedraSemanalesTitulares2a7 = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 1])
                                                ->andWhere(['>=', 'division.id', 9])
                                                ->andWhere(['<=', 'division.id', 53])
                                                ->andWhere(['in', 'detallecatedra.condicion', [1,2,3]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesTitulares2a7 = 0;

            foreach ($horasCatedraSemanalesTitulares2a7 as $horasCatedraSemanalesTitulares2a7ok) {
                $sumaHorasCatedraSemanalesTitulares2a7 = $sumaHorasCatedraSemanalesTitulares2a7 + $horasCatedraSemanalesTitulares2a7ok->hora;
            }

            $horasCatedraSemanalesInterinas2a7 = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 1])
                                                ->andWhere(['>=', 'division.id', 9])
                                                ->andWhere(['<=', 'division.id', 53])
                                                ->andWhere(['in', 'detallecatedra.condicion', [4]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesInterinas2a7 = 0;

            foreach ($horasCatedraSemanalesInterinas2a7 as $horasCatedraSemanalesInterinas2a7ok) {
                $sumaHorasCatedraSemanalesInterinas2a7 = $sumaHorasCatedraSemanalesInterinas2a7 + $horasCatedraSemanalesInterinas2a7ok->hora;
            }

            $horasCatedraSemanalesSuplentes = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 1])
                                                //->andWhere(['>=', 'division.id', 9])
                                                ->andWhere(['<=', 'division.id', 53])
                                                ->andWhere(['in', 'detallecatedra.condicion', [5]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesSuplentes = 0;
            $sumaHorasCatedraSemanalesSuplentes1 = 0;
            $sumaHorasCatedraSemanalesSuplentes2a7 = 0;

            foreach ($horasCatedraSemanalesSuplentes as $horasCatedraSemanalesSuplentesok) {
                $sumaHorasCatedraSemanalesSuplentes = $sumaHorasCatedraSemanalesSuplentes + $horasCatedraSemanalesSuplentesok->hora;
                if($horasCatedraSemanalesSuplentesok->catedra0->division0->id <=8)
                    $sumaHorasCatedraSemanalesSuplentes1 = $sumaHorasCatedraSemanalesSuplentes1 + $horasCatedraSemanalesSuplentesok->hora;
                else
                    $sumaHorasCatedraSemanalesSuplentes2a7 = $sumaHorasCatedraSemanalesSuplentes2a7 + $horasCatedraSemanalesSuplentesok->hora;
                 
            }


            /*PREGRADO*/


            $horasCatedraSemanalesTitularesPregrado = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 2])
                                                ->andWhere(['in', 'detallecatedra.condicion', [1,2,3]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();

            $sumaHorasCatedraSemanalesTitularesPregrado = 0;

            foreach ($horasCatedraSemanalesTitularesPregrado as $horasCatedraSemanalesTitularesPregradook) {
                $sumaHorasCatedraSemanalesTitularesPregrado = $sumaHorasCatedraSemanalesTitularesPregrado + $horasCatedraSemanalesTitularesPregradook->hora;
            }

            $horasCatedraSemanalesInterinasPregrado = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 2])
                                                ->andWhere(['in', 'detallecatedra.condicion', [4]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesInterinasPregrado = 0;

            foreach ($horasCatedraSemanalesInterinasPregrado as $horasCatedraSemanalesInterinasPregradook) {
                $sumaHorasCatedraSemanalesInterinasPregrado = $sumaHorasCatedraSemanalesInterinasPregrado + $horasCatedraSemanalesInterinasPregradook->hora;
            }

            $horasCatedraSemanalesSuplentesPregrado = Detallecatedra::find()
                                                //->select(['sum(hora)'])
                                                ->joinWith(['catedra0.division0', 'catedra0.actividad0'])
                                                ->where(['actividad.propuesta' => 2])
                                                //->andWhere(['>=', 'division.id', 9])
                                                
                                                ->andWhere(['in', 'detallecatedra.condicion', [5]])
                                                ->andWhere(['in', 'detallecatedra.revista', [1]])
                                                ->andWhere(['detallecatedra.activo' => 1])
                                                ->all();
                                                
            $sumaHorasCatedraSemanalesSuplentesPregrado = 0;

            foreach ($horasCatedraSemanalesSuplentesPregrado as $horasCatedraSemanalesSuplentesPregradook) {
                $sumaHorasCatedraSemanalesSuplentesPregrado = $sumaHorasCatedraSemanalesSuplentesPregrado + $horasCatedraSemanalesSuplentesPregradook->hora;
            }

            	        

	        return $this->render('index', 
	        [
                'sumaHorasCatedraSemanalesTitulares1' => $sumaHorasCatedraSemanalesTitulares1,
                'sumaHorasCatedraSemanalesInterinas1' => $sumaHorasCatedraSemanalesInterinas1,
                'sumaHorasCatedraSemanalesTitulares2a7' => $sumaHorasCatedraSemanalesTitulares2a7,
                'sumaHorasCatedraSemanalesInterinas2a7' => $sumaHorasCatedraSemanalesInterinas2a7,
                'sumaHorasCatedraSemanalesSuplentes' => $sumaHorasCatedraSemanalesSuplentes,
                'sumaHorasCatedraSemanalesSuplentes1' => $sumaHorasCatedraSemanalesSuplentes1,
                'sumaHorasCatedraSemanalesSuplentes2a7' => $sumaHorasCatedraSemanalesSuplentes2a7,

                
                'sumaHorasCatedraSemanalesSuplentesPregrado' => $sumaHorasCatedraSemanalesSuplentesPregrado,
                'sumaHorasCatedraSemanalesTitularesPregrado' => $sumaHorasCatedraSemanalesTitularesPregrado,
                'sumaHorasCatedraSemanalesInterinasPregrado' => $sumaHorasCatedraSemanalesInterinasPregrado,
                
	            
                
	        ]);
        }
}