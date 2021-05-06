<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Hora;
use app\models\Horario;
use Yii;
use app\models\Semana;
use app\models\SemanaSearch;
use app\models\Turno;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\horariogenerico\models\Burbuja;
use app\modules\horariogenerico\models\Horareloj;
use app\modules\horariogenerico\models\HorarelojSearch;
use app\modules\horariogenerico\models\Horariogeneric;
use app\modules\horariogenerico\models\HorariogenericSearch;
use kartik\select2\Select2;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * SemanaController implements the CRUD actions for Semana model.
 */
class SemanaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'publicar', 'delete', 'generar', 'operarmasivos', 'cambiartipo', 'operarmasivo', 'copiardesde'],
                'rules' => [
                    
                    [
                        'actions' => ['index', 'view', 'publicar', 'operarmasivos', 'cambiartipo', 'operarmasivo', 'copiardesde'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['create', 'delete', 'generar'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]))
                                    return true;
                                return false;
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
                    'publicar' => ['POST'],
                    'operarmasivos' => ['POST'],
                    'operarmasivo' => ['POST'],
                    'cambiartipo' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Semana models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new SemanaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $semanas = Semana::find()->where(['>=', 'id', 14])->all();
        $events = [];

        
        foreach ($semanas as $semana) {
         
            //if($semana->inicio !=null){
                /*$fechainicio = explode("-",$semana->inicio);
                $fechafin = explode("-",$semana->fin);*/
                try {
                    $tipo = $semana->tiposemana0->nombre;
                    if($semana->tiposemana == 1)
                        $color = '#DEB8EE';
                    else
                        $color = '#79AB5B';
                } catch (\Throwable $th) {
                    $tipo = 'Sin definir';
                    $color = '#a4a4a4';
                }
                
                $newfechainicio = $semana->inicio;
                $fin = $semana->fin;
                if (is_string($semana->fin) === true) $fin = strtotime($semana->fin);
                $newfin = date('Y-m-d', strtotime('+1 day', $fin));

                if($semana->publicada == 1){
                    $publi = '';
                }else
                    $publi = ' (Sin publicar)';
                
                $events[] = new \edofre\fullcalendar\models\Event([
                    'id'               => $semana->id,
                    'title'            => $tipo.$publi,
                    'start'            => $newfechainicio,
                    'end'              => $newfin,
                    //'startEditable'    => true,
                    'color'            => $color,
                    'editable'         => false,
                    'url'              => 'index.php?r=semana/view&id='.$semana->id,
                    'durationEditable' => false,]);
                }

        $horarios = Horariogeneric::find()->select('fecha, burbuja, semana')->distinct()->where(['is not', 'burbuja', null])->andWhere(['>=', 'semana', 14])->all();
        /*$burbujas = ArrayHelper::map($horarios, 'fecha', function($model){
            return $model->burbuja0->nombre.'-'.$model->semana;
        });*/
        //return var_dump($horarios);
        foreach ($horarios as $key => $burbuja) {

            //$expl = explode('-', $burbuja);
            //$burbu = $expl[0];
            //$sem = $expl[1];
            $burbu = $burbuja['burbuja'];
            $sem = $burbuja['semana'];
            $fecha = $burbuja['fecha'];
            $border = null;

            if($burbu == 1){
                $color = '#FFCD80';
                $burbujanom = 'Naranja';
            }
            elseif($burbu == 2){
                $color = '#ADD8E6';
                $burbujanom = 'Azul';
            }
            elseif($burbu == 2){
                $color = '#ADD8E6';
                $burbujanom = 'Azul';
            }
            else{
                $color = '#FFFACD';
                $border = 'grey';
                $burbujanom = 'Amarilla';
            }


            $events[] = new \edofre\fullcalendar\models\Event([
                'id'               => uniqid(),
                'title'            => $burbujanom,
                'start'            => $fecha,
                'end'              => $fecha,
                //'startEditable'    => true,
                'color'            => $color,
                'editable'         => false,
                'borderColor' => $border,
                'textColor' => 'grey',
                'url'              => 'index.php?r=semana/view&id='.$sem,
                'durationEditable' => false,]);
        }
            
        /*if(isset(Yii::$app->request->queryParams['id'])){
            $renderCopiarDesde = $this->getCopiarDesde(Yii::$app->request->queryParams['id'], 'view');
            $renderMasivos = $this->getRenderOperarMasivos(Yii::$app->request->queryParams['id'], 'index');
            $semedit = Semana::findOne(Yii::$app->request->queryParams['id']);

            $fin = $semedit->fin;
                if (is_string($semedit->fin) === true) $fin = strtotime($semedit->fin);
                $newini = date('Y-m-d', strtotime('+1 day', $fin));
                $newfin = date('Y-m-d', strtotime('+3 day', $fin));


            $events[] = new \edofre\fullcalendar\models\Event([
                'id'               => uniqid(),
                'title'            => '(editando) >>>>>>',
                'start'            => $newini,
                'end'              => $newfin,
                //'startEditable'    => true,
                'color'            => 'red',
                'editable'         => false,
                //'borderColor' => $border,
                //'textColor' => 'grey',
                //'className' => 'button-yellow',
                'url'              => 'index.php?r=semana/index',
                'durationEditable' => false,]);
                

        }else{
            $renderMasivos = '';
            $renderCopiarDesde = '';
        }*/

        $infoexamen = "CLASES 2021 - Especiales";
        
        $renderMasivos = $this->renderPartial('@app/modules/horariogenerico/views/horariogeneric/panelprincipal', [
            'infoexamen' => $infoexamen,
            
        ]);
        
        $renderCopiarDesde = '';   
        
        

        return $this->render('index', [
            /*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
            'events' => $events,
            'renderMasivos' => $renderMasivos,
            'renderCopiarDesde' => $renderCopiarDesde,
        ]);
    }

    protected function getHora ($turno){
        $h = [];
        if($turno == 1){
            $h[1] = '7:15 a 7:55';
            $h[2] = '8:00 a 8:40';
            $h[3] = '8:45 a 9:25';
            $h[4] = '9:30 a 10:10';
            $h[5] = '10:20 a 11:00';
            $h[6] = '11:05 a 11:45';
            $h[7] = '11:50 a 12:30';
            $h[8] = '12:35 a 13:15';
        }elseif ($turno == 2) {
            $h[0] = '12:30 a 13:30';
            $h[1] = '13:30 a 14:10';
            $h[2] = '14:15 a 14:55';
            $h[3] = '15:00 a 15:40';
            $h[4] = '15:45 a 16:25';
            $h[5] = '16:35 a 17:15';
            $h[6] = '17:20 a 18:00';
            $h[7] = '18:05 a 18:45';
            $h[8] = '18:50 a 19:30';
        }
        return $h;
    }

    /**
     * Displays a single Semana model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $edit = true, $anio = null, $turno = null, $pes = 1)
    {
        
        $anios = ['1' => '1°', '2' => '2°', '3' => '3°', '4' => '4°', '5' => '5°', '6' => '6°', '7' => '7°'];
        $turnos = Turno::find()->where(['<', 'id', 3])->all();
        $horas = Hora::find()->all();

        $modelHorareloj = new Horareloj();
        $modelHorareloj->semana = $id;

        
        
        if ($modelHorareloj->load(Yii::$app->request->post())) {
            //return var_dump($modelHorareloj);
            $horasX = Yii::$app->request->post()['Horareloj']['hora'];
            foreach ($horasX as $horaX) {
                $horaRelojx = new Horareloj();
                $horaRelojx->semana = $id;
                $horaRelojx->hora = $horaX;
                $horaRelojx->anio = $modelHorareloj->anio;
                $horaRelojx->turno = $modelHorareloj->turno;
                $h = $this->getHora($modelHorareloj->turno);
                $h2 = explode(' a ', $h[$horaX-1]);
                $horaRelojx->inicio = $h2[0];
                $horaRelojx->fin = $h2[1];
                $horaRelojx->save();
                

                
            }
            
            return $this->redirect(['view', 'id' => $id, 'turno' => $horaRelojx->turno, 'anio' => $horaRelojx->anio]);
        }

        $searchModel = new HorarelojSearch();
        $dataProvider = $searchModel->porsemana($id, $turno, $anio);

        $modelHorareloj->anio = $anio;
        $modelHorareloj->turno = $turno;


        /*Dias de la semana*/
        $model = $this->findModel($id);

        try {
            $sema = Semana::findOne($model->id-1);
        } catch (\Throwable $th) {
            $sema = null;
        }

        try {
            $semn = Semana::findOne($model->id+1);
        } catch (\Throwable $th) {
            $semn = null;
        }


        $start = $model->inicio;
        $end = $model->fin;

        $fechas = [];

        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            
            
            $horarios = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.division0'])
            ->where(['semana' => $id])
            ->andWhere(['LEFT(division.nombre, 1)' => $anio])
            ->andWhere(['turno' => $turno])
            ->andWhere(['fecha' => date('Y-m-d', $start)])
            ->all();

            if(count($horarios)>0){

                $fechas[date('Y-m-d', $start)]['fecha'] = $dias2[(date('w', $start)-1)].' '.date('d/m', $start);

                $burbujas = ArrayHelper::map($horarios, 'burbuja', function($model){
                    try {
                        return $model->burbuja;
                    } catch (\Throwable $th) {
                        return '';
                    }
                    
                });

                $burbujascombo = Burbuja::find()->all();
                $burbujascombo = ArrayHelper::map($burbujascombo, 'id', 'nombre');

                $bur = '';

                if(count($burbujas)==0){
                    $fechas[date('Y-m-d', $start)]['burbuja'] = 'Sin definir';
                }elseif(count($burbujas)==1){
                    foreach ($burbujas as $burbuja) {
                        $bur = $burbuja;
                        break;
                    }
                    if($bur == '')
                        $bur = 'Sin definir';
                    try {
                        $fechas[date('Y-m-d', $start)]['burbuja'] = Burbuja::findOne($bur)->nombre;
                    } catch (\Throwable $th) {
                        $fechas[date('Y-m-d', $start)]['burbuja'] = $bur;
                    }
                    
                }else{
                    $fechas[date('Y-m-d', $start)]['burbuja'] = 'Personalizada';
                }


                $fechas[date('Y-m-d', $start)]['cambiar'] = '<span class="col-md-6">'.Select2::widget([
                    'name' => date('Y-m-d', $start),
                    'data' => $burbujascombo,
                    'value' => $bur,
                    'options' => [
                        'placeholder' => 'Seleccionar',
                        
                    ],
                ]).'</span><span class="col-md-6">'.Html::submitButton('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', ['class' => 'btn btn-primary', "name" => "btn_submit", "value" => $id.'*'.$anio.'*'.$turno.'*'.date('Y-m-d', $start)]).'</span>';

            }
            
            $start = strtotime("+ 1 day", $start);


        } while($start <= $end);

        //return var_dump($fechas);
        $fechas = new ArrayDataProvider([
            'allModels' => $fechas,
            
        ]);


        if (Yii::$app->request->post()) {

            //return $this->redirect(['view', 'burtodos' => Yii::$app->request->post(), $semana]);
            
            $params = Yii::$app->request->post();
            $expl = explode('*', $params['btn_submit']);
            $semana = $expl[0];
            $anio = $expl[1];
            $turno = $expl[2];
            $fecha = $expl[3];
            $burbuja = $params[$fecha];

            if($burbuja != ''){
                $horarios = Horariogeneric::find()
                            ->joinWith(['catedra0', 'catedra0.division0'])
                            ->where(['semana' => $semana])
                            ->andWhere(['LEFT(division.nombre, 1)' => $anio])
                            ->andWhere(['division.turno' => $turno])
                            ->andWhere(['horariogeneric.fecha' => $fecha])
                            ->all();
            
                foreach ($horarios as $horario) {
                    $horario->burbuja = $burbuja;
                    $horario->save();
                }
            }
            return $this->redirect(['/semana/view', 'id' => $semana, 'anio' => $anio, 'turno' =>$turno]);
           

        }


        $searchModelReportexsemana = new HorariogenericSearch();
        $dataProviderReportexsemana = $searchModelReportexsemana->reporteporsemana($id);

        $renderMasivos = $this->getRenderOperarMasivos($id, 'view');
        $renderCopiarDesde = $this->getCopiarDesde($id, 'view');

        //return var_dump($fechas);
        if($pes == 1){
            $p1 = 'class="active"';
            $p2 = '';
            $p3 = '';
            $p4 = '';

            $fade1 = 'in active';
            $fade2 = '';
            $fade3 = '';
            $fade4 = '';

        }elseif($pes == 2){
            $p2 = 'class="active"';
            $p1 = '';
            $p3 = '';
            $p4 = '';

            $fade2 = 'in active';
            $fade1 = '';
            $fade3 = '';
            $fade4 = '';
        }elseif($pes == 3){
            $p3 = 'class="active"';
            $p1 = '';
            $p2 = '';
            $p4 = '';

            $fade3 = 'in active';
            $fade1 = '';
            $fade2 = '';
            $fade4 = '';
        }else{
            $p4 = 'class="active"';
            $p1 = '';
            $p2 = '';
            $p3 = '';

            $fade4 = 'in active';
            $fade1 = '';
            $fade2 = '';
            $fade3 = '';
        }


        return $this->render('view', [
            'model' => $model,
            'edit' => $edit,
            'anios' => $anios,
            'turnos' => $turnos,
            'horas' => $horas,
            'modelHorareloj' => $modelHorareloj,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fechas' => $fechas,
            'sema' => $sema,
            'semn' => $semn,
            'searchModelReportexsemana' => $searchModelReportexsemana,
            'dataProviderReportexsemana' => $dataProviderReportexsemana,

            'renderMasivos' => $renderMasivos,
            'renderCopiarDesde' => $renderCopiarDesde,
            'fade1' => $fade1,
            'fade2' => $fade2,
            'fade3' => $fade3,
            'fade4' => $fade4,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,

            



            'anio' => $anio,
            'turno' => $turno,
            'semana' => $id,
        ]);
    }

    public function actionOperarmasivos($origen){

        if (Yii::$app->request->post()) {

            //return $this->redirect(['view', 'burtodos' => Yii::$app->request->post(), $semana]);
            
            $params2 = Yii::$app->request->post();
            $expl2 = explode('*', $params2['btn_submit']);
            $semana2 = $expl2[0];
            $fecha2 = $expl2[3];
            $burbuja2 = $params2[$fecha2];

            if($burbuja2 != ''){
                $horarios2 = Horariogeneric::find()
                            ->joinWith(['catedra0', 'catedra0.division0'])
                            ->where(['semana' => $semana2])
                            ->andWhere(['horariogeneric.fecha' => $fecha2])
                            ->all();
            
                foreach ($horarios2 as $horario2) {
                    $horario2->burbuja = $burbuja2;
                    $horario2->save();
                }
            }
            Yii::$app->session->setFlash('success', "Se generaron correctamente los horarios");
            return $this->redirect(['/semana/'.$origen, 'id' => $semana2, 'pes' => 3]);
           

        }

    }

    public function actionCopiardesde($origen){


        

        if (Yii::$app->request->post()){
            $param = Yii::$app->request->post();

            //return var_dump($param['Horariogeneric']['semana']);

            $semana = $param['btn_submit_semana'];
            $sem = Semana::findOne($semana);
            $fechasdestino = $sem->getFechas();

            

            $horasX = Hora::find()->all();
            $turnos = Turno::find()->where(['<', 'id', 3])->all();
            $anios = ['1' => '1°', '2' => '2°', '3' => '3°', '4' => '4°', '5' => '5°', '6' => '6°', '7' => '7°'];

            $horasorigen = Horareloj::find()->where(['semana' => $param['Horariogeneric']['semana']])->all();
            
            $horasorigen = ArrayHelper::map($horasorigen, function($model){
                return $model->turno.'-'.$model->anio.'-'.$model->hora;
            }, function($model){
                return $model->inicio.' a '.$model->fin;
            });
            //return var_dump($horasorigen);
            

            foreach ($turnos as $turno) {
                //$h = $this->getHora($turno->id);
                foreach ($anios as $keyanios => $anio) {
                    foreach ($horasX as $horaX) {
                        try {
                        $horaRelojx = new Horareloj();
                        $horaRelojx->semana = $semana;
                        $horaRelojx->hora = $horaX->id;
                        $horaRelojx->anio = $keyanios;
                        $horaRelojx->turno = $turno->id;
                        
                        //$h2 = explode(' a ', $h[$horaX->id-1]);
                        $h2 = explode(' a ', $horasorigen[$turno->id.'-'.$keyanios.'-'.$horaX->id]);
                        $horaRelojx->inicio = $h2[0];
                        $horaRelojx->fin = $h2[1];
                        
                            $horaRelojx->save();
                        } catch (\Throwable $th) {
                            
                        }
                        
                        
                    }
                }
            }

            
            $semanaorigen = Semana::findOne($param['Horariogeneric']['semana']);
            foreach ($semanaorigen->horariogenerics as $key => $horarioorigen) {

                $anio = substr($horarioorigen->catedra0->division0->nombre, 0, 1);

                $horarelojatrabajar = Horareloj::find()
                        ->where(['semana' => $sem->id])
                        ->andWhere(['anio' => $anio])
                        ->andWhere(['turno' => $horarioorigen->catedra0->division0->turno])
                        ->all();

                $horarelojatrabajar = ArrayHelper::map($horarelojatrabajar, 'hora', 'id');


                $existe = Horariogeneric::find()
                        ->joinWith('catedra0')
                        ->where(['semana' => $sem->id])
                        ->andWhere(['fecha' => $fechasdestino[$horarioorigen->diasemana]])
                        ->andWhere(['horareloj' => $horarelojatrabajar[$horarioorigen->horareloj0->hora]])
                        ->andWhere(['catedra.division' => $horarioorigen->catedra0->division])
                        ->one();
                
                if($existe != null){
                    $nuevoHorario = $existe;
                }else{
                    $nuevoHorario = new Horariogeneric();
                }

                $nuevoHorario->catedra = $horarioorigen->catedra;
                $nuevoHorario->diasemana = $horarioorigen->diasemana;
                $nuevoHorario->semana = $sem->id;
                $nuevoHorario->aniolectivo = $horarioorigen->aniolectivo;
                $nuevoHorario->burbuja = $horarioorigen->burbuja;
                $nuevoHorario->fecha = $fechasdestino[$horarioorigen->diasemana];
                $nuevoHorario->horareloj = $horarelojatrabajar[$horarioorigen->horareloj0->hora];
                $nuevoHorario->save();

            }
            Yii::$app->session->setFlash('success', "Se generaron correctamente los horarios");
            return $this->redirect(['/semana/'.$origen, 'id' => $semana, 'pes' => 2]);
            

        }


    }


    public function getCopiarDesde($semana, $origen){

        $sem = Semana::findOne($semana);
        $model = new Horariogeneric();
        $semanasorigen = Semana::find()
                ->where(['<>', 'id', $semana])
                ->andWhere(['tiposemana' => $sem->tiposemana])
                ->all();
        if($sem->tiposemana == null)
            return '<div class="alert alert-warning">
            <strong>Info</strong> Debe designar el tipo de semana como <i>Virtual</i> o <i>Presencial</i> para copiar los horarios.
            </div>';

        if(count($sem->horariogenerics)>0){
            return '<div class="alert alert-warning">
            <strong>Info</strong> No se puede copiar, ya que existen horarios cargados.
            </div>';
        }

        return $this->renderPartial('copiardesde', [
            'semana' => $semana,
            'sem' => $sem,
            'model' => $model,
            'semanasorigen' => $semanasorigen,
            'origen' => $origen,
        ]);

    }

    

    public function getRenderOperarMasivos($semana, $origen){

        $model = Semana::findOne($semana);

        $start = $model->inicio;
        $end = $model->fin;

        $fechasmasivas = [];

        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            
            
            $horarios = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.division0'])
            ->where(['semana' => $semana])
            ->andWhere(['fecha' => date('Y-m-d', $start)])
            ->all();

            if(count($horarios)>0){

                $fechasmasivas[date('Y-m-d', $start)]['fecha'] = $dias2[(date('w', $start)-1)].' '.date('d/m', $start);

                $burbujas = ArrayHelper::map($horarios, 'burbuja', function($model){
                    try {
                        return $model->burbuja;
                    } catch (\Throwable $th) {
                        return '';
                    }
                    
                });

                $burbujascombo = Burbuja::find()->all();
                $burbujascombo = ArrayHelper::map($burbujascombo, 'id', 'nombre');

                $bur = '';

                if(count($burbujas)==0){
                    $fechasmasivas[date('Y-m-d', $start)]['burbuja'] = 'Sin definir';
                }elseif(count($burbujas)==1){
                    foreach ($burbujas as $burbuja) {
                        $bur = $burbuja;
                        break;
                    }
                    if($bur == '')
                        $bur = 'Sin definir';
                    try {
                        $fechasmasivas[date('Y-m-d', $start)]['burbuja'] = Burbuja::findOne($bur)->nombre;
                    } catch (\Throwable $th) {
                        $fechasmasivas[date('Y-m-d', $start)]['burbuja'] = $bur;
                    }
                    
                }else{
                    $fechasmasivas[date('Y-m-d', $start)]['burbuja'] = 'Personalizada';
                }


                $fechasmasivas[date('Y-m-d', $start)]['cambiar'] = '<span class="col-md-6">'.Select2::widget([
                    'name' => date('Y-m-d', $start),
                    'data' => $burbujascombo,
                    'value' => $bur,
                    'options' => [
                        'placeholder' => 'Seleccionar',
                        
                    ],
                ]).'</span><span class="col-md-6">'.Html::submitButton('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', ['class' => 'btn btn-primary', "name" => "btn_submit", "value" => $semana.'*'.$semana.'*'.$semana.'*'.date('Y-m-d', $start)]).'</span>';

            }
            
            $start = strtotime("+ 1 day", $start);


        } while($start <= $end);

        //return var_dump($fechas);
        $fechasmasivas = new ArrayDataProvider([
            'allModels' => $fechasmasivas,
            
        ]);

        if($model->tiposemana != null){
            $tiposemana = $model->tiposemana0->nombre;
        }else{
            $tiposemana = 'ss';
        }

        return $this->renderPartial('operarmasivos', [
            'semana' => $semana,
            'fechasmasivas' => $fechasmasivas,
            'tiposemana' => $tiposemana,
            'origen' => $origen,
        ]);

    }

    public function actionOperarmasivo($semana, $origen){

        //$param = Yii::$app->request->post();
        //$semana = $param['semana'];
        $horasX = Hora::find()->where(['>', 'id', 1])->all();
        $turnos = Turno::find()->where(['<', 'id', 3])->all();
        $anios = ['1' => '1°', '2' => '2°', '3' => '3°', '4' => '4°', '5' => '5°', '6' => '6°', '7' => '7°'];
        foreach ($turnos as $turno) {
            $h = $this->getHora($turno->id);
            foreach ($anios as $keyanios => $anio) {
                foreach ($horasX as $horaX) {
                    $horaRelojx = new Horareloj();
                    $horaRelojx->semana = $semana;
                    $horaRelojx->hora = $horaX->id;
                    $horaRelojx->anio = $keyanios;
                    $horaRelojx->turno = $turno->id;
                    
                    $h2 = explode(' a ', $h[$horaX->id-1]);
                    $horaRelojx->inicio = $h2[0];
                    $horaRelojx->fin = $h2[1];
                    try {
                        $horaRelojx->save();
                    } catch (\Throwable $th) {
                        
                    }
                    
                    
                }
            }
        }


        $sem = Semana::findOne($semana);
        $aniolectivo = $sem->aniolectivo;

        if($sem->tiposemana == 1)

            $horariosoriginales = Horario::find()
                                ->joinWith(['catedra0', 'catedra0.division0'])
                                ->where(['aniolectivo' => $aniolectivo])
                                //->andWhere(['LEFT(division.nombre, 1)' => $anio])
                                //->andWhere(['division.turno' => $turno])
                                ->andWhere(['horario.tipo' => 1])
                                ->andWhere(['<=', 'division.id', 53])
                                ->andWhere(['<>','horario.hora', 2])
                                ->andWhere(['<>','horario.hora', 9])
                                ->orderBy('horario.diasemana, hora')
                                ->all();
        else
            $horariosoriginales = Horario::find()
                ->joinWith(['catedra0', 'catedra0.division0'])
                ->where(['aniolectivo' => $aniolectivo])
                ->andWhere(['<=', 'division.id', 53])
                //->andWhere(['LEFT(division.nombre, 1)' => $anio])
                //->andWhere(['division.turno' => $turno])
                ->andWhere(['horario.tipo' => 1])
                ->orderBy('horario.diasemana, hora')
                ->all();
        
        //return var_dump($horariosoriginales);

        //return var_dump($sem->fechas);

        //var_dump($horariosoriginales);

        $fechas = $sem->fechas;
        /*$horasrelojm = Horareloj::find()
                        ->where(['semana' => $sem->id])
                        //->andWhere(['anio' => $anio])
                        ->andWhere(['turno' => 1])
                        ->all();
        $horasrelojt = Horareloj::find()
                        ->where(['semana' => $sem->id])
                        //->andWhere(['anio' => $anio])
                        ->andWhere(['turno' => 2])
                        ->all();

        
        
        $horasrelojm = ArrayHelper::map($horasrelojm, 'hora', 'id');
        $horasrelojt = ArrayHelper::map($horasrelojt, 'hora', 'id');*/

        
        foreach ($horariosoriginales as $original) {

                $anio = substr($original->catedra0->division0->nombre, 0, 1);

                $horarelojatrabajar = Horareloj::find()
                        ->where(['semana' => $sem->id])
                        ->andWhere(['anio' => $anio])
                        ->andWhere(['turno' => $original->catedra0->division0->turno])
                        ->all();

                $horarelojatrabajar = ArrayHelper::map($horarelojatrabajar, 'hora', 'id');


                $existe = Horariogeneric::find()
                        ->joinWith('catedra0')
                        ->where(['semana' => $sem->id])
                        ->andWhere(['fecha' => $fechas[$original->diasemana]])
                        ->andWhere(['horareloj' => $horarelojatrabajar[$original->hora]])
                        ->andWhere(['catedra.division' => $original->catedra0->division])
                        ->one();
                
                if($existe != null){
                    $nuevoHorario = $existe;
                }else{
                    $nuevoHorario = new Horariogeneric();
                }
                        
                
                $nuevoHorario->catedra = $original->catedra;
                $nuevoHorario->diasemana = $original->diasemana;
                $nuevoHorario->semana = $sem->id;
                $nuevoHorario->aniolectivo = $aniolectivo;
                $nuevoHorario->fecha = $fechas[$original->diasemana];
                $nuevoHorario->horareloj = $horarelojatrabajar[$original->hora];
                $nuevoHorario->save();
            
            
        }
        
        return $this->redirect(['/semana/'.$origen, 'id' => $semana, 'pes' => 3]);

    }

    public function actionGenerar($al)
    {
        $anio = Aniolectivo::findOne($al);
        $primerlunes = strtotime($anio->nombre."-01-04");
        $fechaFin = strtotime($anio->nombre."-12-31");

        //Recorro las fechas y con la función strotime obtengo los lunes
        $lunes = [];
        $viernes = [];

        $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");

        for ($i = $primerlunes; $i <= $fechaFin; $i += 86400 * 7){
            $lunes=date("Y-m-d",$i);
            $viernes =date("Y-m-d", strtotime("+ 4 day", $i));
            $semana = new Semana();
            $semana->aniolectivo = $al;
            $semana->inicio = $lunes;
            $semana->fin = $viernes;
            $semana->publicada = 0;
            $semana->save();
        }


        return var_dump($viernes);
        
    }

    /**
     * Creates a new Semana model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Semana();
        $aniolectivo = Aniolectivo::find()->all();
        $publicado = [0=> "No", 1 => "Sí"];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'aniolectivo' => $aniolectivo,
            'publicado' => $publicado,
        ]);
    }

    /**
     * Updates an existing Semana model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPublicar($semana)
    {
       
        $model = $this->findModel($semana);
        if($model->publicada == 0)
            $model->publicada = 1;
        else
            $model->publicada = 0;
        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
        
    }

    public function actionCambiartipo($semana)
    {
       
        $model = $this->findModel($semana);

        $sem = Semana::findOne($semana);

        

        if($model->tiposemana == 2 || $model->tiposemana == null){
            $model->tiposemana = 1;
            $horarios = Horariogeneric::find()
                        ->joinWith(['horareloj0'])
                        ->where(['horariogeneric.semana' => $semana])
                        ->andWhere(['or', 
                                ['horareloj.hora' => 2],
                                ['horareloj.hora' => 9]
                        ])
                        ->all();
            foreach ($horarios as $horario) {
               $horario->delete();
            }
        }
            
        else{

            /*$horariosoriginales = Horario::find()
                                ->joinWith(['catedra0', 'catedra0.division0'])
                                ->where(['aniolectivo' => $sem->aniolectivo])
                                ->andWhere(['horario.tipo' => 1])
                                ->andWhere(['or', 
                                    ['hora' => 2],
                                    ['hora' => 9]
                                ])
                                ->orderBy('division.id, horario.diasemana, hora')
                                ->all();

            
            $fechas = $sem->fechas;

            foreach ($horariosoriginales as $original) {
                $anio = substr($original->catedra0->division0->nombre, 0, 1);
                $turno = $original->catedra0->division0->turno;
                $horasreloj = Horareloj::find()
                                ->where(['semana' => $sem->id])
                                ->andWhere(['anio' => $anio])
                                ->andWhere(['turno' => $turno])
                                ->andWhere(['or', 
                                    ['hora' => 2],
                                    ['hora' => 9]
                                ])
                                ->all();
                
                $horasreloj = ArrayHelper::map($horasreloj, 'hora', 'id');
                
                try {
                $existe = Horariogeneric::find()
                        ->joinWith('catedra0')
                        ->where(['semana' => $sem->id])
                        ->andWhere(['fecha' => $fechas[$original->diasemana]])
                        ->andWhere(['horareloj' => $horasreloj[$original->hora]])
                        ->andWhere(['catedra.division' => $original->catedra0->division])
                        ->one();
                
                if($existe != null){
                    $nuevoHorario = $existe;
                }else{
                    $nuevoHorario = new Horariogeneric();
                }

                    $nuevoHorario->catedra = $original->catedra;
                    $nuevoHorario->diasemana = $original->diasemana;
                    $nuevoHorario->semana = $sem->id;
                    $nuevoHorario->aniolectivo = $sem->aniolectivo;
                    $nuevoHorario->fecha = $fechas[$original->diasemana];
                    $nuevoHorario->horareloj = $horasreloj[$original->hora];
                    $nuevoHorario->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }
                

            }*/
            
            

            $model->tiposemana = 2;
        }
            



        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
        
    }

    /**
     * Deletes an existing Semana model.
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
     * Finds the Semana model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Semana the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Semana::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
