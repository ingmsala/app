<?php

namespace app\modules\becas\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\Division;
use app\modules\becas\models\Becaalumno;
use app\modules\becas\models\Becaconviviente;
use app\modules\becas\models\Becaconvocatoria;
use app\modules\becas\models\Becaestadoxsolicitud;
use app\modules\becas\models\Becapersona;
use Yii;
use app\modules\becas\models\Becasolicitud;
use app\modules\becas\models\BecasolicitudSearch;
use DateTime;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * BecasolicitudController implements the CRUD actions for Becasolicitud model.
 */
class BecasolicitudController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'recalcular', 'recalculartodas', 'reenviar', 'obtenerpuntaje'],
                'rules' => [
                    [
                        'actions' => ['view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                                
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['index', 'recalcular', 'recalculartodas', 'reenviar', 'obtenerpuntaje'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_BECAS]);
                                
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
                    'recalcular' => ['POST'],
                    'recalculartodas' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Becasolicitud models.
     * @return mixed
     */
    public function actionIndex($convocatoria)
    {
        $model = new Becasolicitud();
        try {
            $model->divisiones = Yii::$app->request->post()['Becasolicitud']['divisiones'];
        } catch (\Throwable $th) {
            $model->divisiones = 0;
        }
        
        $searchModel = new BecasolicitudSearch();
        $dataProvider = $searchModel->xconvocatroria($convocatoria, $model->divisiones);
        $divisiones = Division::find()->where(['<=', 'preceptoria', 6])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'divisiones' => $divisiones,
            'model' => $model,
            'convocatoria' => $convocatoria,
        ]);
    }



public function actionRecalculartodas(){
    $conv = Yii::$app->request->post()['conv'];
    $conv = Becaconvocatoria::findOne($conv);
    ini_set("pcre.backtrack_limit", "5000000");
    foreach ($conv->becasolicituds as $sol) {
        $this->getRecalcular($sol->id);
    }
    Yii::$app->session->setFlash('success', "Se recalcularon correctamente todos los puntajes");
    return $this->redirect(['index', 'convocatoria' => $conv->id]);
}

public function actionRecalcular()
    {
        $sol = Yii::$app->request->post()['sol'];
        $this->getRecalcular($sol);
        $sol = $this->findModel($sol);
        Yii::$app->session->setFlash('success', "Se recalculó correctamente el puntaje");
        return $this->redirect(['index', 'convocatoria' => $sol->convocatoria]);
    }
    public function actionReenviar()
    {
        $sol = Yii::$app->request->post()['sol'];
        $sol = $this->findModel($sol);
        $sendemail=Yii::$app->mailer->compose()
                        ->setFrom([Globales::MAIL => 'Sistema de Becas CNM'])
                        ->setTo($sol->solicitante0->mail)
                        ->setSubject('Reenvío de enlace de beca')
                        ->setHtmlBody('
                            Se reenvía nuevamente el enlace para que pueda modificar y enviar la solicitud hasta la fecha '.Yii::$app->formatter->asDate($sol->convocatoria0->hasta, 'dd/MM').' ingresando a '.Html::a('http://admin.cnm.unc.edu.ar/front/index.php?r=becas%2Fdefault%2Fsolicitud&s='.$sol->token, Url::to(['/becas/default/solicitud', 's' => $sol->token], true)).'
                        <br> Recuede que todos los datos deben estar completos (incluidos los de todas las personas - menores y mayores - que conviven con el/la estudiante) para que sea evaluada por el Área de Becas del Colegio. Es necesario que complete los 3 pasos y en el último presione el botón "Enviar Solicitud". Luego de esa fecha no será posible realizar modificaciones. <br> <br> Por favor no conteste este correo ya que se envió de manera automatica y la casilla no es revisada por personal de la Institución. Si tiene alguna duda o consulta puede realizarla a través de los canales oficiales del Colegio a secretaria_rei@cnm.unc.edu.ar')
                        ->send();
        if($sendemail)
        {
            //unlink(Yii::getAlias('@app').'/runtime/logs/'.$filename.'.pdf');
            Yii::$app->session->setFlash('success', "Se reenvió correctamente el mail con el enlace de modificación. Se pasó la solicitud a estado 'Iniciada' y se eliminó el puntaje");
            $sol->puntaje = null;
            $sol->estado = 1;
            $sol->save();

            $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

            $solicitudestado = new Becaestadoxsolicitud();
            $solicitudestado->solicitud = $sol->id;
            $solicitudestado->estado = 1;
            $solicitudestado->agente = $persona->id;
            $solicitudestado->fecha = date('Y-m-d H:i:s');
            $solicitudestado->solicitud = $sol->id;
            $solicitudestado->save();
        }

        
        return $this->redirect(['index', 'convocatoria' => $sol->convocatoria]);
    }


    public function actionObtenerpuntaje($sol)
    {
        $sol = $this->findModel($sol);

        $puntajeconvivientes = 0;
        $estudiante = 0;
        $conviviente = 0;
        $menor = 0;
        $mayor = 0;
        $cantconv = 0;

        $array = [];
        $arraymenor = [];
        $arraymayor = [];

        $puntajeestudiante = $this->getPuntaje($sol->estudiante0->persona, $sol);
        $estudiante = $puntajeestudiante ['puntaje'];
        $menor += $puntajeestudiante ['menor'];
        $mayor += $puntajeestudiante ['mayor'];
        //return var_dump($puntajeestudiante);
        if($puntajeestudiante ['menor']>0)
            $arraymenor[] = $sol->estudiante0;
        else
            $arraymayor[] = $sol->estudiante0;

        $array ['estudiante'][]= $puntajeestudiante;
        
        foreach ($sol->becaconvivientes as $convivientex) {
            $puntajeconvivientes = $this->getPuntaje($convivientex->persona, $sol);
            $conviviente += $puntajeconvivientes ['puntaje'];
            $menor += $puntajeconvivientes ['menor'];
            $mayor += $puntajeconvivientes ['mayor'];
            $cantconv ++;
            $array ['convivientes'][]= $puntajeconvivientes;
            if($puntajeconvivientes ['menor']>0)
                $arraymenor[] = $convivientex;
            else
                $arraymayor[] = $convivientex;
        }
        //return var_dump($puntajeconvivientes);

        $cantmenor = $menor;
        $cantmayor = $mayor;

        if($menor>5)
            $menor = 10;
        else
            $menor = $menor*2;

        if($mayor>5)
            $mayor = 5;
            
        try {
            $conviviente = $conviviente/$cantconv;
        } catch (\Throwable $th) {
            $conviviente = 0;
        }
        

        $puntajefinal = (float)($estudiante + $conviviente + $menor + $mayor);
        

        /*$providerEstudiante = new ArrayDataProvider([
            'allModels' => $array['estudiante'],
            
        ]);*/

        $modelEstudiante = $array['estudiante'];
        $modelConvivientes = $array['convivientes'];

        return $this->renderAjax('obtenerpuntaje', [
            'sol' => $sol,
            'modelEstudiante' => $modelEstudiante,
            'modelConvivientes' => $modelConvivientes,
            'estudiante' => $estudiante,
            'conviviente' => round($conviviente,2),
            'cantmenor' => $cantmenor,
            'cantmayor' => $cantmayor,
            'pjemenor' => $menor,
            'pjemayor' => $mayor,
            'arraymenor' => $arraymenor,
            'arraymayor' => $arraymayor,
            'puntajefinal' => round($puntajefinal,2),
            
        ]);
        
    }

    /**
     * Displays a single Becasolicitud model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function getRecalcular($sol)
    {
        
        $sol = $this->findModel($sol);

        $puntajeconvivientes = 0;
        $estudiante = 0;
        $conviviente = 0;
        $menor = 0;
        $mayor = 0;
        $cantconv = 0;

        $puntajeestudiante = $this->getPuntaje($sol->estudiante0->persona, $sol);
        $estudiante = $puntajeestudiante ['puntaje'];
        $menor += $puntajeestudiante ['menor'];
        $mayor += $puntajeestudiante ['mayor'];
        //return var_dump($puntajeestudiante);
        
        foreach ($sol->becaconvivientes as $convivientex) {
            $puntajeconvivientes = $this->getPuntaje($convivientex->persona, $sol);
            $conviviente += $puntajeconvivientes ['puntaje'];
            $menor += $puntajeconvivientes ['menor'];
            $mayor += $puntajeconvivientes ['mayor'];
            $cantconv ++;
        }
        //return var_dump($puntajeconvivientes);
        if($menor>5)
            $menor = 10;
        else
            $menor = $menor*2;

        if($mayor>5)
            $mayor = 5;
            
        try {
            $conviviente = $conviviente/$cantconv;
        } catch (\Throwable $th) {
            $conviviente = 0;
        }
        

        $puntajefinal = (float)($estudiante + $conviviente + $menor + $mayor);

        //return $puntajefinal;
        
        $sol->puntaje = $puntajefinal;
        $sol->estado = 4;
        $sol->save();

        $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $solicitudestado = new Becaestadoxsolicitud();
        $solicitudestado->solicitud = $sol->id;
        $solicitudestado->estado = 4;
        $solicitudestado->agente = $persona->id;
        $solicitudestado->fecha = date('Y-m-d H:i:s');
        $solicitudestado->solicitud = $sol->id;
        $solicitudestado->save();
        
        
    }

    private function getPuntaje($persona, $sol){
        $menor = 0;
        $mayor = 0;
        $puntaje = 0;

        $nivelestudio = 0;
        $situacionocupacional = 0;
        $ayuda = 0;
        
        $persona = Becapersona::findOne($persona);
        $personax = Becaalumno::find()->where(['persona' => $persona->id])->one();
        if($personax == null)
            $personax = Becaconviviente::find()->where(['persona' => $persona->id])->one();

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date_create($personax->fechanac);
        $hoy = new DateTime($sol->convocatoria0->hasta);
        $interval = date_diff( $fecha, $hoy);
        $edad = $interval->y;

        if($edad<18){
            $menor = 1;
            $coef = 1.1;
        }else{
            $mayor = 1;
            $coef = 1;
        }
        
        $arraynivelestudio = [
            1 => 20,
            2 =>18,
            3 => 15,
            4=>15,
            5=>13,
            6=>13,
            7=>10,
            8=>13,
            9=>10,
            10=>5,
            11=>0,
        ];

        $arrayayudas = [
            1=>0,
            2=>8,
            3=>10,
        ];

        $arrayocupacional = [
            1=>25,
            2=>10,
            3=>10,
            4=>15,
            5=>10,
            6=>25,
            7=>20,
            8=>25,
        ];
        
        $nivelestudio = $arraynivelestudio[$personax->nivelestudio];

        $cayuda = 0;
        $sumayuda = 0;
        foreach ($persona->becaayudapersonas as $ay) {
            if($ay->ayuda<>1){
                $cayuda++;
                $sumayuda = $sumayuda+$arrayayudas[$ay->ayuda];
            }
        }

        try {
            $ayuda = $sumayuda/$cayuda;
        } catch (\Throwable $th) {
            $ayuda = 0;
        }

        $cocup = 0;
        $sumocup = 0;
        $banest = false;
        $bantrab = false;
        
        foreach ($persona->becaocupacionpersonas as $ocup) {
            if($ocup->ocupacion==8){
                $banest = false;
                $cocup=1;
                $sumocup = $arrayocupacional[$ocup->ocupacion];
                break;
            }elseif($ocup->ocupacion==1){
                $banest = true;
            }elseif($ocup->ocupacion == 4 || $ocup->ocupacion == 5 ||$ocup->ocupacion == 6){
                $bantrab = true;
            }else{
                //algo
            }
            
            $cocup++;
            $sumocup = $sumocup+$arrayocupacional[$ocup->ocupacion];
            
        }

        if($banest && $bantrab){
            $cocup=1;
            $sumocup = 30;
        }

        try {
            $situacionocupacional = $sumocup/$cocup;
        } catch (\Throwable $th) {
            $situacionocupacional = 0;
        }

        
        
        $puntaje = round(($nivelestudio + $situacionocupacional + $ayuda)*$coef,2);

        return [
            'puntaje' => $puntaje,
            'menor' => $menor,
            'mayor' => $mayor,
            'nivelestudio' => $nivelestudio,
            'situacionocupacional' => $situacionocupacional,
            'ayuda' => $ayuda,
            'coef' => $coef,
            'persona' => $personax,
        ];


    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Becasolicitud model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Becasolicitud();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Becasolicitud model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Becasolicitud model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Becasolicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Becasolicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Becasolicitud::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
