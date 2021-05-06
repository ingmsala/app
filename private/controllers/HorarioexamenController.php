<?php

namespace app\controllers;

use Yii;
use app\models\Horarioexamen;
use app\models\HorarioexamenSearch;
use app\models\Anioxtrimestral;
use app\models\Catedra;
use app\models\Preceptoria;
use app\models\Hora;
use app\models\Tipoparte;
use app\models\Agente;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Division;
use app\config\Globales;
use yii\data\ArrayDataProvider;
use app\models\DetallecatedraSearch;
use app\models\Nombramiento;
use app\models\Rolexuser;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\base\ErrorException;
/**
 * HorarioexamenController implements the CRUD actions for Horarioexamen model.
 */
class HorarioexamenController extends Controller
{
    /**
     * {@inheritdoc}
     */
   
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'menuxdivision', 'completoxcurso', 'completoxdia', 'completoxdocente', 'createdesdehorario', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'updatedesdehorario', 'filtropormateria', 'horariocompleto', 'print', 'printcursos', 'migracionfechas', 'revisarhorarios', 'mesasxfecha'],
                'rules' => [
                    [
                        'actions' => ['completoxdia', 'completoxdocente', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'filtropormateria', 'horariocompleto'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_CONSULTA_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR])){
                                        return true;
                                    /*}elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                                        $division = Yii::$app->request->queryParams['division'];
                                        $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
                                        $aut = Division::find()
                                            ->where(['preceptoria' => $pre->id])
                                            ->andWhere(['id' => $division])
                                            ->all();
                                        if(count($aut)>0)
                                            return true;
                                        else
                                            return false;*/
                                        }else{
                                        return false;
                                    }

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],

                    [
                        'actions' => ['printcursos'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA])){
                                        return true;
                                    /*}elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                                        $division = Yii::$app->request->queryParams['division'];
                                        $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
                                        $aut = Division::find()
                                            ->where(['preceptoria' => $pre->id])
                                            ->andWhere(['id' => $division])
                                            ->all();
                                        if(count($aut)>0)
                                            return true;
                                        else
                                            return false;*/
                                        }else{
                                        return false;
                                    }

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],

                    [
                        'actions' => ['completoxcurso'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_CONSULTA_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
                                        return true;
                                    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                                        
                                        $division = Yii::$app->request->queryParams['division'];
                                        $role = Rolexuser::find()
                                                    ->where(['user' => Yii::$app->user->identity->id])
                                                    ->andWhere(['role' => Globales::US_PRECEPTORIA])
                                                    ->one();

                                        $pre = Preceptoria::find()->where(['nombre' => $role->subrole])->one();
                                        $aut = Division::find()
                                            ->where(['preceptoria' => $pre->id])
                                            ->andWhere(['id' => $division])
                                            ->all();
                                        if(count($aut)>0)
                                            return true;
                                        else
                                            return false;
                                    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                                        $division = Yii::$app->request->queryParams['division'];
                                        $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                        $nom = Nombramiento::find()
                                                    ->where(['agente' => $doc->id])
                                                    ->andWhere(['<=', 'division', 53])
                                                    //->andWhere(['is not', 'division', 53])
                                                    ->all();
                                        $array = [];
                                        foreach ($nom as $n) {
                                            $array [] = $n->division;
                                        }
                                        if(in_array($division, $array))
                                            return true;
                                        else
                                            return false;

                                    }else{
                                        return false;
                                    }

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],

                    [
                        'actions' => ['menuxdivision'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_CONSULTA_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
                                        return true;
                                    
                                    }else{
                                        return false;
                                    }

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],

                   

                    [
                        'actions' => ['view', 'create', 'update'],   
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
                        'actions' => ['index', 'createdesdehorario','updatedesdehorario', 'print', 'migracionfechas', 'delete', 'revisarhorarios', 'mesasxfecha'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                                    return true;
                                }/*elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                                        $division = Yii::$app->request->queryParams['division'];
                                        $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
                                        $aut = Division::find()
                                            ->where(['preceptoria' => $pre->id])
                                            ->andWhere(['id' => $division])
                                            ->all();
                                        if(count($aut)>0)
                                            return true;
                                        else
                                            return false;

                                    }*/else{
                                        return false;
                                    }
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

    /**
     * Lists all Horarioexamen models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new HorarioexamenSearch();
        $dataProvider = $searchModel->search($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horarioexamen model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Horarioexamen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horarioexamen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Horarioexamen model.
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
     * Deletes an existing Horarioexamen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $h=0, $col=0)
    {
        $horarioexamen = $this->findModel($id);
        $anioxtrimestral = $horarioexamen->anioxtrimestral;
        $division = $horarioexamen->catedra0->division;

        $monologComponent = Yii::$app->monolog;
            if($horarioexamen->tipo == 2)
                $logger = $monologComponent->getLogger("horarioexamen");
            else
                $logger = $monologComponent->getLogger("horariocoloquio");
            $logger->log('error', json_encode([
                "username" => Yii::$app->user->identity->username,
                "action" => Yii::$app->controller->action->id,
                "modelnew" => $horarioexamen->getAttributes(),
                "modelold" => [],
            ]));
        $horarioexamen->delete();
        if($h == 0){
            return $this->redirect(['index', 'id'=>$anioxtrimestral]);
        }else{
            return $this->redirect(['/horarioexamen/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'prt'=>0, 'col'=>$col]);
        }
        
    }

    /**
     * Finds the Horarioexamen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horarioexamen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horarioexamen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*public function actionGenerar($anioxtrim){

        $cat = [
            
                0 => '81',
                1 => '58',
                2 => '26',
                3 => '34',
                4 => '10',
                5 => '2',
                6 => '61',
                7 => '6',
                8 => '7',
                9 => '8',
                10 => '162',
                11 => '130',
                12 => '108',
                13 => '109',
                14 => '149',
                15 => '174',
                16 => '126',
                17 => '166',
                18 => '158',
                19 => '142',
                20 => '110',
                21 => '102',
                22 => '127',
                23 => '167',
                24 => '111',
                25 => '235',
                26 => '268',
                27 => '286',
                28 => '865',
                29 => '252',
                30 => '236',
                31 => '204',
                32 => '196',
                33 => '276',
                34 => '205',
                35 => '238',
                36 => '206',
                37 => '278',
                38 => '279',
                39 => '354',
                40 => '363',
                41 => '331',
                42 => '339',
                43 => '323',
                44 => '299',
                45 => '291',
                46 => '355',
                47 => '347',
                48 => '364',
                49 => '378',
                50 => '372',
                51 => '332',
                52 => '316',
                53 => '340',
                54 => '324',
                55 => '308',
                56 => '300',
                57 => '292',
                58 => '356',
                59 => '348',
                60 => '366',
                61 => '334',
                62 => '318',
                63 => '342',
                64 => '326',
                65 => '302',
                66 => '294',
                67 => '358',
                68 => '335',
                69 => '351',
                70 => '458',
                71 => '490',
                72 => '418',
                73 => '426',
                74 => '434',
                75 => '474',
                76 => '410',
                77 => '402',
                78 => '394',
                79 => '482',
                80 => '442',
                81 => '419',
                82 => '435',
                83 => '443',
                84 => '420',
                85 => '461',
                86 => '493',
                87 => '421',
                88 => '437',
                89 => '397',
                90 => '389',
                91 => '485',
                92 => '462',
                93 => '470',
                94 => '406',
                95 => '495',
                96 => '440',
                97 => '408',
                98 => '575',
                99 => '554',
                100 => '589',
                101 => '526',
                102 => '547',
                103 => '568',
                104 => '540',
                105 => '533',
                106 => '596',
                107 => '519',
                108 => '512',
                109 => '505',
                110 => '582',
                111 => '561',
                112 => '590',
                113 => '513',
                114 => '562',
                115 => '556',
                116 => '578',
                117 => '592',
                118 => '529',
                119 => '571',
                120 => '543',
                121 => '536',
                122 => '599',
                123 => '515',
                124 => '585',
                125 => '564',
                126 => '579',
                127 => '558',
                128 => '593',
                129 => '530',
                130 => '551',
                131 => '572',
                132 => '544',
                133 => '537',
                134 => '600',
                135 => '516',
                136 => '586',
                137 => '565',
                138 => '580',
                139 => '559',
                140 => '594',
                141 => '531',
                142 => '552',
                143 => '573',
                144 => '545',
                145 => '538',
                146 => '601',
                147 => '524',
                148 => '517',
                149 => '587',
                150 => '566',
                151 => '646',
                152 => '634',
                153 => '694',
                154 => '622',
                155 => '628',
                156 => '682',
                157 => '640',
                158 => '658',
                159 => '647',
                160 => '648',
                161 => '678',
                162 => '696',
                163 => '624',
                164 => '672',
                165 => '630',
                166 => '642',
                167 => '660',
                168 => '679',
                169 => '697',
                170 => '673',
                171 => '631',
                172 => '650',
                173 => '656',
                174 => '680',
                175 => '698',
                176 => '626',
                177 => '674',
                178 => '632',
                179 => '686',
                180 => '620',
                181 => '614',
                182 => '644',
                183 => '662',
                184 => '639',
                185 => '699',
                186 => '633',
                187 => '645',
                188 => '663',
        ];

        $horarios = Horarioexamen::find()
                        //->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.detallecatedras.agente0', 'catedra0.actividad0', 'catedra0.division0'])
                        
                        ->where(['not in', 'catedra', $cat])
                        ->andWhere(['anioxtrimestral' => $anioxtrim])
                        //->andWhere(['detallecatedra.revista' => 6])
                        //->andWhere(['detallecatedra.aniolectivo' => 2])
                       // ->orderBy('catedra.division')
                        ->all();

        foreach ($horarios as $horario) {
            $horario->delete();
        }

        return var_dump(count($horarios));


    }*/

    public function actionCompletoxcurso($division, $vista, $prt=0, $col=0){
        return $this->generarHorarioCurso($division, $vista, $prt, $col);
    }

    public function generarHorarioCurso($division, $vista, $prt, $col=0)
    {
        //$division = 1;
        //$dia = 3;

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR)
            $this->layout = 'mainpersonal';
        $searchModel = new HorarioexamenSearch();
        $paramdivision = Division::findOne($division);
        $h= [];
        
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        if($paramdivision->turno == 1){
            $h[1] = $anioxtrim->h1m;
            $h[2] = $anioxtrim->h2m;
            
        }elseif ($paramdivision->turno == 2) {
            $h[1] = $anioxtrim->h1t;
            $h[2] = $anioxtrim->h2t;
            
        }

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }

        $horarios = Horarioexamen::find()
            ->joinWith(['catedra0'])
            ->where(['anioxtrimestral' => $anioxtrim->id])
            ->andWhere(['catedra.division' => $division])
            //->andWhere(['tipo' => 1])
            ->orderBy('fecha')
            ->all();

        $start = $anioxtrim->inicio;
        $end = $anioxtrim->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        //return var_dump($range);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        $diasgrid = [];
        $diasgrid['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgrid['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        //'attribute' => '999',
                        'value' => function($model) use($prt){
                            if($prt==1)
                                return $model['999'];
                            else
                                return '<span class="badge">'.$model['999'].'</span>';
                        }
                    ];
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];
        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;

            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgrid['columns'][] =  [
                            'header' => ($prt==1) ? $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia : $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                

                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $array[$hora->id][999] = $h[$ch+1]; 
                    if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                        if($prt==1)
                            $array[$hora->id][$fechats] = "-";
                        else
                            $array[$hora->id][$fechats] = '<a class="btn btn-info btn-sm" href="?r=horarioexamen/createdesdehorario&division='.$division.'&hora='.$hora->id.'&fecha='.$fechats.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                    else
                        $array[$hora->id][$fechats] = "-";
                    //$key = array_search($hora->id, array_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $cd){

                    
                    }*/
                    $ch = $ch + 1;
                }  
            }
            
            $cd = $cd + 1;
        }
        //return var_dump($array);
        $salida = '';
        $listdc = [];
        foreach ($horarios as $horariox) {
            
                            foreach ($horariox->catedra0->detallecatedras as $dc) {

                                $salida = '';
                                if ($dc->revista == 6){
                                    //return var_dump($dc['revista']==1);
                                    $listdc[] = $dc->id;
                                    $cant = array_count_values($listdc)[$dc->id];
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->fecha, $tipo, $anioxtrim->id);
                                    
                                    if ($superpuesto[0]){
                                        if($cant>1){
                                            $superpuesto[1] = str_replace('</ul>', $horariox->catedra0->division0->nombre."</ul>", $superpuesto[1]);
                                        }
                                        ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else{
                                        if($cant>1){
                                            ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.'<ul>'.$horariox->catedra0->division0->nombre.'</ul>'.'">'.$dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1).'</span>'.'</span>';
                                        }else{
                                            $salida = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);

                                        }
                                    }
                                    
                                    break 1;
                                }else{
                                    $salida = 'vacante';
                                }
                            }
                           //return $salida;
            if($vista == 'docentes'){
                if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                    if($prt==1)
                        $array[$horariox->hora][$horariox->fecha] = $salida;
                    else
                        //$array[$horariox->hora][$horariox->fecha] = $salida.'<div class="pull-right"><a class="btn btn-success btn-sm" href="?r=horarioexamen/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&fecha='.$horariox->fecha.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>';
                        $array[$horariox->hora][$horariox->fecha] = '<a class="btn btn-link btn-sm" href="?r=horarioexamen/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&fecha='.$horariox->fecha.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'">'.$salida.'</a>';
                else
                    $array[$horariox->hora][$horariox->fecha] = $salida;
            }else
                $array[$horariox->hora][$horariox->fecha] = $horariox->catedra0->actividad0->nombre;
        }

        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);
        //return var_dump($array);
        
        $docente_materia_search = new DetallecatedraSearch();
        $dataProvider = $docente_materia_search->horario_doce_divi($division, $anioxtrim->aniolectivo);

        if($prt == 1)
                return $this->renderAjax('completoxcurso', [
                //'model' => $model,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                //'dataProviderMartes' => $dataProviderMartes,
                'provider' => $provider,
                'paramdivision' => $paramdivision,
                'vista' => $vista,
                'diasgrid' => $diasgrid,
                'al' => $anioxtrim->aniolectivo,
                'trimestral' => $anioxtrim->trimestral0->nombre,
                'prt' => $prt,
                'listdc' => $listdc,
                'col' => $col,

            ]);
        return $this->render('completoxcurso', [
            //'model' => $model,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'paramdivision' => $paramdivision,
            'vista' => $vista,
            'diasgrid' => $diasgrid,
            'al' => $anioxtrim->aniolectivo,
            'trimestral' => $anioxtrim->trimestral0->nombre,
            'prt' => $prt,
            'listdc' => $listdc,
            'col' => $col,

        ]);
    }

    public function actionCreatedesdehorario($division, $hora, $fecha, $tipo, $alxtrim, $col)
    {
        $model = new Horarioexamen();
        //$model->scenario = $model::SCENARIO_CREATEHORARIO;
        $model->hora = $hora;
        $model->fecha = $fecha;
        $model->tipo = $tipo;
        $model->anioxtrimestral = $alxtrim;

        if ($model->load(Yii::$app->request->post())) {


            $model->save();
            $monologComponent = Yii::$app->monolog;
            if($tipo == 2)
                $logger = $monologComponent->getLogger("horarioexamen");
            else
                $logger = $monologComponent->getLogger("horariocoloquio");
            $logger->log('info', json_encode([
                "username" => Yii::$app->user->identity->username,
                "action" => Yii::$app->controller->action->id,
                "modelnew" => $model->getAttributes(),
                "modelold" => [],
            ]));
            return $this->redirect(['/horarioexamen/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'col' => $col]);
        }

        

        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $division = Division::findOne($division);
        $tipos = Tipoparte::find()->all();
        return $this->render('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'tipos' => $tipos,
            'catedras' => $catedras,
        ]);
    }

    public function horaSuperpuesta($dc, $hora, $fecha, $tipo, $al){
        $agente = $dc->agente;
        $horarios = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'catedra.division', $dc->catedra0->division])
            ->andWhere(['horarioexamen.hora' => $hora])
            ->andWhere(['horarioexamen.fecha' => $fecha])
            //->andWhere(['horarioexamen.id' => $anioxtrim->id])
            ->andWhere(['anioxtrimestral.id' => $al])
            ->andWhere(['division.turno' => $dc->catedra0->division0->turno])
            ->all();
        if (count($horarios)>0){
            $salida = '<ul>';
            foreach ($horarios as $sup) {
                $salida .= '<li>'.$sup->catedra0->division0->nombre.'</li>';
            }
            $salida .= '</ul>';
            return [true, $salida];
        }
            
        else
            return [false, ''];
    }

    public function actionUpdatedesdehorario($division, $hora, $fecha, $tipo, $alxtrim, $col)
    {
        $model = Horarioexamen::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['hora' => $hora])
                    ->andWhere(['anioxtrimestral' => $alxtrim])
                    ->andWhere(['fecha' => $fecha])
                    ->andWhere(['tipo' => $tipo])
                    ->one();
        

        if ($model->load(Yii::$app->request->post())) {
           //    $model->catedra = $model->catedra;

            $model->anioxtrimestral = $alxtrim;

            $monologComponent = Yii::$app->monolog;
            if($tipo == 2)
                $logger = $monologComponent->getLogger("horarioexamen");
            else
                $logger = $monologComponent->getLogger("horariocoloquio");
            $logger->log('warning', json_encode([
                "username" => Yii::$app->user->identity->username,
                "action" => Yii::$app->controller->action->id,
                "modelnew" => $model->getAttributes(),
                "modelold" => $model->getOldAttributes(),
            ]));
           $model->save();

            return $this->redirect(['/horarioexamen/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'col' => $col]);
        }

        $division = Division::findOne($division);
        $catedras = Catedra::find()->where(['division' => $division->id])->all();
        $horas = Hora::find()->where(['>', 'id', 1])->all();
        //$dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'tipos' => $tipos,
            'catedras' => $catedras,
            'col' => $col,
        ]);
    }

    public function actionMenuxdivision($col = 0)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        
        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }

        if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            $role = Rolexuser::find()
                        ->where(['user' => Yii::$app->user->identity->id])
                        ->andWhere(['role' => Globales::US_PRECEPTORIA])
                        ->one();

            $pre = Preceptoria::find()->where(['nombre' => $role->subrole])->one();
            $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();
        }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            $this->layout = 'mainpersonal';
            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $nom = Nombramiento::find()
                        ->where(['agente' => $doc->id])
                        ->andWhere(['<=', 'division', 53])
                        //->andWhere(['is not', 'division', 53])
                        ->all();
            $array = [];
            foreach ($nom as $n) {
                $array [] = $n->division;
            }
            //$pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
            $divisiones = Division::find()
                        ->where(['in', 'id', $array])
                        ->orderBy('id')
                        ->all();
                    
        }else{
            $divisiones = Division::find()
                                ->where(['in', 'preceptoria', [1,2,3,4,5,6]])
                                ->orderBy('id')
                                ->all();
        }

        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_REGENCIA])){
            $vista = 'docentes';
        }else{
            $vista = 'materias';
        }
        
        $echodiv = '';
        foreach ($divisiones as $division) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horarioexamen/completoxcurso&division='.$division->id.'&vista='.$vista.'&prt=0&col='.$col.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivision', [
            'echodiv' => $echodiv,
            'col' => $col,
            'anioxtrim' => $anioxtrim,
        ]);
    }

    public function actionPanelprincipal($col)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        if($col == 0)
            $infoexamen = "TRIMESTRALES";
        else{
            $infoexamen = "Febrero/Marzo 2021";
        }
        return $this->render('panelprincipal', [
            'infoexamen' => $infoexamen,
            'col' => $col,
        ]);
    }
    public function actionMenuxletra($col = 0)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }
        $model = new Agente();
        $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        //$docentes = Agente::find()->select('id, LEFT(apellido, 1) AS inicial, apellido, nombre')->orderBy('apellido, nombre')->all();
        $echodiv = '';
        $echodiv .= '<div class="row">';
        foreach ($abecedario as $letra) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horarioexamen/menuxdocenteletra&letra='.$letra.'&col='.$col.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        $echodiv .= '</div>';

        /*if ($model->load(Yii::$app->request->post())) {
            $id = Yii::$app->request->post()['Agente']['apellido'];
            return $this->redirect(['completoxdocente', 'agente' =>  $id]);
        }*/

        return $this->render('menuxletra', [
            
            'echodiv' => $echodiv,
            'col' => $col,
            
        ]);
    }

    public function actionMenuxdocenteletra($letra, $col = 0)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }
        $model = new Agente();
        $docentes = Agente::find()
            ->joinWith('detallecatedras')
            ->where(['like', 'apellido', $letra.'%', false])
            ->andWhere(['=', 'detallecatedra.revista', 6])
            ->orderBy('apellido, nombre')->all();
        

        $echodiv = '';
        foreach ($docentes as $doc) {
                $echodiv .= '<div class="pull-left" style="height: 21vh; width:29vh; vertical-align: middle;">';
                $echodiv .= '<div>';
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horarioexamen/completoxdocente&agente='.$doc->id.'&col='.$col.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
            'col' => $col,
            
        ]);
    }


    public function actionCompletoxdocente($agente, $col)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioexamenSearch();
        $docenteparam = Agente::findOne($agente);

        $h= [];
        $j= [];
        
            

        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha1print = Yii::$app->formatter->asDate($anioxtrim->inicio, 'dd/MM/yyyy');
            $fecha2print = Yii::$app->formatter->asDate($anioxtrim->fin, 'dd/MM/yyyy');
            $infocabecera = "Se comumica que los exámenes trimestrales correspondientes al <b>{$anioxtrim->trimestral0->nombre}</b> comenzarán el <b>{$fecha1print}</b> y teminarán el <b>{$fecha2print}</b>. Deberá entregarlos con las correciones pertinentes con un plazo máximo de <b><u>TRES DÍAS</u></b> siguientes a su recepción. Luego se archivarán en preceptoría.<br/>
            Saludamos a Usted muy atte.";
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
            $infocabecera = '';
        }
            
        $h[1] = $anioxtrim->h1m;
        $h[2] = $anioxtrim->h2m;
        
    
        $j[1] = $anioxtrim->h1t;
        $j[2] = $anioxtrim->h2t;
                
        $horariosTm = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['horarioexamen.anioxtrimestral' => $anioxtrim->id])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        $horariosTt = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['horarioexamen.anioxtrimestral' => $anioxtrim->id])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        
        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }


        $start = $anioxtrim->inicio;
        $end = $anioxtrim->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;
        //return var_dump($dias);
        $arrayTm = [];
        $salida = '';

        $diasgridtm = [];
        $diasgridtm['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtm['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        'value' => function($model){
                            return '<span class="badge">'.$model['999'].'</span>';
                        }
                    ];
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;

            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtm['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTm[$hora->id][999] = $h[$ch+1]; 
                    $arrayTm[$hora->id][$fechats] = '';
                    //$key = arrayTm_search($hora->id, arrayTm_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }
            $cd = $cd + 1;
        }
        $salida = '';
        foreach ($horariosTm as $horarioxTm) {
                
                if($arrayTm[$horarioxTm->hora][$horarioxTm->fecha] != ''){
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre;
                }
                
        }

        $providerTm = new ArrayDataProvider([
            'allModels' => $arrayTm,
            
        ]);
        
        $arrayTt = [];
        $salida = '';

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;

        $diasgridtt = [];
        $diasgridtt['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtt['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        'value' => function($model){
                            return '<span class="badge">'.$model['999'].'</span>';
                        }
                    ];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;


            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtt['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'contentOptions' => function ($model, $key, $index, $column) use($fechats) {
                                    return ['style' => 'background-color:' 
                                . (strpos($model[$fechats], ' - ') === true) ? 'red' : 'black'];
                             },
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTt[$hora->id][999] = $j[$ch+1];
                    $arrayTt[$hora->id][$fechats] = '';
                    //$key = arrayTt_search($hora->id, arrayTt_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }   
            $cd = $cd + 1;
        }
        $salida = '';
        //return var_dump($diasgridtt);
        foreach ($horariosTt as $horarioxTt) {
            
                            
                           //return $salida;
            /*if($vista == 'docentes')
                $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] = $salida;
            else*/
                if($arrayTt[$horarioxTt->hora][$horarioxTt->fecha] != ''){
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre;
                }
        }

        $providerTt = new ArrayDataProvider([
            'allModels' => $arrayTt,
            
        ]);

        return $this->render('completoxdocente', [
            
            'providerTm' => $providerTm,
            'providerTt' => $providerTt,
            'docenteparam' => $docenteparam,
            'diasgridtm' => $diasgridtm,
            'diasgridtt' => $diasgridtt,
            'anioxtrimestral' => $anioxtrim,
            'infocabecera' => $infocabecera,
            'col' => $col,
            
        ]);
    }

    public function actionHorariostrimestrales($col = 0){
        //$this->layout = 'print';
        
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        $agente = Agente::find()->joinWith('detallecatedras')
        ->where(['mail' => Yii::$app->user->identity->username])
        ->andWhere(['=', 'detallecatedra.revista', 6])
        ->one();

        if($anioxtrim == null || $anioxtrim->publicado !=1){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horario/menuopcionespublic']);
        }
       
        
        
            /*
            $agente = Agente::find()
                ->joinWith('detallecatedras')
                ->where(['=', 'detallecatedra.revista', 6])
                ->andWhere(['=', 'agente.legajo', $agente])
                ->one();*/
        
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            return $this->redirect(['menuxdivision']);
        }
            
            return $this->generarFicha2($agente->id, $col);
            
    }

    public function generarFicha2($agente, $col)
    {
        //$division = 1;
        //$dia = 3;
        
        $this->layout = 'mainpersonal';
        $searchModel = new HorarioexamenSearch();
        $docenteparam = Agente::findOne($agente);

        $h= [];
        $j= [];
        
            
          
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha1print = Yii::$app->formatter->asDate($anioxtrim->inicio, 'dd/MM/yyyy');
            $fecha2print = Yii::$app->formatter->asDate($anioxtrim->fin, 'dd/MM/yyyy');
            $infocabecera = "Se comumica que los exámenes trimestrales correspondientes al <b>{$anioxtrim->trimestral0->nombre}</b> comenzarán el <b>{$fecha1print}</b> y teminarán el <b>{$fecha2print}</b>. Deberá entregarlos con las correciones pertinentes con un plazo máximo de <b><u>TRES DÍAS</u></b> siguientes a su recepción. Luego se archivarán en preceptoría.<br/>
            Saludamos a Usted muy atte.";
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
            $infocabecera = '';
        }  

        $h[1] = $anioxtrim->h1m;
        $h[2] = $anioxtrim->h2m;
        
    
        $j[1] = $anioxtrim->h1t;
        $j[2] = $anioxtrim->h2t;
        
                
        $horariosTm = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['detallecatedra.aniolectivo' => $anioxtrim->aniolectivo])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        $horariosTt = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['detallecatedra.aniolectivo' => $anioxtrim->aniolectivo])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        
        if($anioxtrim == null || $anioxtrim->publicado !=1){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }

        $start = $anioxtrim->inicio;
        $end = $anioxtrim->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;
        //return var_dump($dias);
        $arrayTm = [];
        $salida = '';

        $diasgridtm = [];
        $diasgridtm['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtm['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        
                    ];
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;

            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtm['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia,
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTm[$hora->id][999] = $h[$ch+1]; 
                    $arrayTm[$hora->id][$fechats] = '';
                    //$key = arrayTm_search($hora->id, arrayTm_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }
            $cd = $cd + 1;
        }
        $salida = '';
        foreach ($horariosTm as $horarioxTm) {
                
                if($arrayTm[$horarioxTm->hora][$horarioxTm->fecha] != ''){
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre;
                }
                
        }

        $providerTm = new ArrayDataProvider([
            'allModels' => $arrayTm,
            
        ]);
        
        $arrayTt = [];
        $salida = '';

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;

        $diasgridtt = [];
        $diasgridtt['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtt['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        
                    ];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;


            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtt['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia,
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'contentOptions' => function ($model, $key, $index, $column) use($fechats) {
                                    return ['style' => 'background-color:' 
                                . (strpos($model[$fechats], ' - ') === true) ? 'red' : 'black'];
                             },
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTt[$hora->id][999] = $j[$ch+1];
                    $arrayTt[$hora->id][$fechats] = '';
                    //$key = arrayTt_search($hora->id, arrayTt_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }   
            $cd = $cd + 1;
        }
        $salida = '';
        //return var_dump($diasgridtt);
        foreach ($horariosTt as $horarioxTt) {
            
                            
                           //return $salida;
            /*if($vista == 'docentes')
                $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] = $salida;
            else*/
                if($arrayTt[$horarioxTt->hora][$horarioxTt->fecha] != ''){
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre;
                }
        }

        $providerTt = new ArrayDataProvider([
            'allModels' => $arrayTt,
            
        ]);
        

        return $this->render('completoxdocentepublic', [
            
            'providerTm' => $providerTm,
            'providerTt' => $providerTt,
            'docenteparam' => $docenteparam,
            'diasgridtm' => $diasgridtm,
            'diasgridtt' => $diasgridtt,
            'anioxtrimestral' => $anioxtrim,
            'infocabecera' => $infocabecera,
            'col' => $col,
            
        ]);
    }



    public function generarFicha($agente, $col)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioexamenSearch();
        $docenteparam = Agente::findOne($agente);

        $h= [];
        $j= [];
        
        
          
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha1print = Yii::$app->formatter->asDate($anioxtrim->inicio, 'dd/MM/yyyy');
            $fecha2print = Yii::$app->formatter->asDate($anioxtrim->fin, 'dd/MM/yyyy');
            $infocabecera = "Se comumica que los exámenes trimestrales correspondientes al <b>{$anioxtrim->trimestral0->nombre}</b> comenzarán el <b>{$fecha1print}</b> y teminarán el <b>{$fecha2print}</b>. Deberá entregarlos con las correciones pertinentes con un plazo máximo de <b><u>TRES DÍAS</u></b> siguientes a su recepción. Luego se archivarán en preceptoría.<br/>
            Saludamos a Usted muy atte.";
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
            $infocabecera = '';
        }  

        $h[1] = $anioxtrim->h1m;
        $h[2] = $anioxtrim->h2m;
        
    
        $j[1] = $anioxtrim->h1t;
        $j[2] = $anioxtrim->h2t;
        
                
        $horariosTm = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['horarioexamen.anioxtrimestral' => $anioxtrim->id])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        $horariosTt = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'anioxtrimestral0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['horarioexamen.anioxtrimestral' => $anioxtrim->id])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['anioxtrimestral.id' => $anioxtrim->id])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        
        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }

        $start = $anioxtrim->inicio;
        $end = $anioxtrim->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;
        //return var_dump($dias);
        $arrayTm = [];
        $salida = '';

        $diasgridtm = [];
        $diasgridtm['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtm['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        
                    ];
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;

            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtm['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia,
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTm[$hora->id][999] = $h[$ch+1]; 
                    $arrayTm[$hora->id][$fechats] = '';
                    //$key = arrayTm_search($hora->id, arrayTm_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }
            $cd = $cd + 1;
        }
        $salida = '';
        foreach ($horariosTm as $horarioxTm) {
                
                if($arrayTm[$horarioxTm->hora][$horarioxTm->fecha] != ''){
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre;
                }
                
        }

        $providerTm = new ArrayDataProvider([
            'allModels' => $arrayTm,
            
        ]);
        
        $arrayTt = [];
        $salida = '';

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $cd = 0;

        $diasgridtt = [];
        $diasgridtt['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtt['columns'][] =[
                        'label' => 'Horario',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'attribute' => '999',
                        
                    ];

        foreach ($dias as $dia) {
            $ch = 0;
            $fechats = $dia;


            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                $diasgridtt['columns'][] =  [
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia,
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'contentOptions' => function ($model, $key, $index, $column) use($fechats) {
                                    return ['style' => 'background-color:' 
                                . (strpos($model[$fechats], ' - ') === true) ? 'red' : 'black'];
                             },
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTt[$hora->id][999] = $j[$ch+1];
                    $arrayTt[$hora->id][$fechats] = '';
                    //$key = arrayTt_search($hora->id, arrayTt_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

                    
                    }*/
                    $ch = $ch + 1;
                }
            }   
            $cd = $cd + 1;
        }
        $salida = '';
        //return var_dump($diasgridtt);
        foreach ($horariosTt as $horarioxTt) {
            
                            
                           //return $salida;
            /*if($vista == 'docentes')
                $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] = $salida;
            else*/
                if($arrayTt[$horarioxTt->hora][$horarioxTt->fecha] != ''){
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre;
                }
        }

        $providerTt = new ArrayDataProvider([
            'allModels' => $arrayTt,
            
        ]);

        return $this->renderAjax('completoxdocente', [
            
            'providerTm' => $providerTm,
            'providerTt' => $providerTt,
            'docenteparam' => $docenteparam,
            'diasgridtm' => $diasgridtm,
            'diasgridtt' => $diasgridtt,
            'anioxtrimestral' => $anioxtrim,
            'infocabecera' => $infocabecera,
            'col' => $col,
            
        ]);
    }

    public function actionPrint($agente, $all, $col = 0){
        //$this->layout = 'print';
        
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salidaimpar = '';
        
        if($all){
            ini_set("pcre.backtrack_limit", "5000000");
            
            $docentes = Agente::find()
                ->distinct()
                ->joinWith('detallecatedras')
                ->where(['=', 'detallecatedra.revista', 6])
                ->orderBy('apellido, nombre')->all();

            
            foreach ($docentes as $doc) {
            $salidaimpar .= $this->generarFicha($doc->id, $col);
            
            }
            $filnamesinext = "{$anioxtrim->aniolectivo0->nombre} - Citaciones {$anioxtrim->trimestral0->nombre}";
            $filename = $filnamesinext.".pdf";
        }else{
            $mat = Agente::findOne($agente);
            $salidaimpar = $this->generarFicha($agente, $col);
            $filnamesinext = $mat->apellido.'_'.$mat->nombre;
            $filename = $filnamesinext.'.pdf';
        }
        
        
        $content = $this->renderAjax('all', [
                'salidaimpar' => $salidaimpar,
                
               
            ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        'marginTop' => 45,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $filename, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
                

                .col-sm-2 {
                        width: 7%;
                        
                   } 
                .horarioexamen-view{
                    margin-top: -70px;
                    max-height: 100%;
                    overflow: hidden;
                    page-break-after: always;
                }

                .pull-right {
                    display: none;
                }
                

                #encabezado{ 
                    padding-bottom: 500px;
                    
                    width: 200px;

                }', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['<span><img src="assets/images/logo-encabezado.png" /></span>'], 
            'SetFooter'=>['<span class"pull-left" style="font-size: 8px;">Puede consultar su horario online ingresando con su Usuario UNC en la web <a href="http://admin.cnm.unc.edu.ar">admin.cnm.unc.edu.ar</a></span>    -    '.date('d/m/Y').' - '.$filnamesinext ],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }

    public function actionPrintcursos($division, $all, $col = 0){
        //$this->layout = 'print';
        
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
        }
        else{
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['trimestral' => 4])
                            ->one();
            $tipo = 3;
        }

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario");
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario");
                return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            }
        }
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salidaimpar = '';
        
        if($all){
            ini_set("pcre.backtrack_limit", "5000000");
            
            if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                $role = Rolexuser::find()
                            ->where(['user' => Yii::$app->user->identity->id])
                            ->andWhere(['role' => Globales::US_PRECEPTORIA])
                            ->one();

                $pre = Preceptoria::find()->where(['nombre' => $role->subrole])->one();
                $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();
            }else{
                $divisiones = Division::find()
                                        ->where(['in', 'turno', [1,2]])
                                        ->orderBy('id')
                                        ->all();
            }

            
            foreach ($divisiones as $divi) {
                $salidaimpar .= $this->generarHorarioCurso($divi->id, 'materias', 1, $col);
            
            }
            $filenamesext = "{$anioxtrim->aniolectivo0->nombre} - Horario Completo - {$anioxtrim->trimestral0->nombre}";
            $filename = $filenamesext.".pdf";
        }else{
            $di = Division::findOne($division);
            $salidaimpar = $this->generarHorarioCurso($division, 'materias', 1, $col);
            $filenamesext = "{$anioxtrim->aniolectivo0->nombre} - Horario {$anioxtrim->trimestral0->nombre} - {$di->nombre}";
            $filename =$filenamesext.".pdf";
        }
        
        
        $content = $this->renderAjax('all', [
                'salidaimpar' => $salidaimpar,
                
               
            ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        'marginTop' => 45,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_DOWNLOAD, 
        'filename' => $filename, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
                

                .col-sm-2 {
                        width: 7%;
                        
                   } 
                .horarioxcurso-view{
                    margin-top: -70px;
                    max-height: 100%;
                    overflow: hidden;
                    page-break-after: always;
                }

                .pull-right {
                    display: none;
                }
                

                #encabezado{ 
                    padding-bottom: 500px;
                    
                    width: 200px;

                }', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Colegio Nacional de Monserrat'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'defaultheaderline' => 0,
            'SetHeader'=>['<span><img src="assets/images/logo-encabezado.png" /></span>'], 
            'SetFooter'=>[date('d/m/Y')." - ".$filenamesext],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }

    public function actionMigracionfechas($anioxtrimestral, $origenduplicado){
        $axt = Anioxtrimestral::findOne($anioxtrimestral);
        $axtorigen = Anioxtrimestral::findOne($origenduplicado);
        
        if($axtorigen==null){
            return $this->redirect(['/anioxtrimestral']);
        }
        
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if($axt->trimestral<4){
            $tipo = 2;
            $col = 0;
        }else{
            $tipo = 3;
            $col = 1;
        }

        $htrimprueba = Horarioexamen::find()
                ->select('fecha')
                ->distinct()
                //->where(['tipo' => 2])
                ->andWhere(['anioxtrimestral' => $axtorigen->id])
                ->orderBy('fecha')
                ->all();


        

        /*if(count($htexamen)==0 && $tipo == 3){
            $nuevoexamen = true;
        }else{
            $nuevoexamen = false;
        }*/

        $salida = '';
        $salida .='<div class="content">';
        $c = 0;
        $form = ActiveForm::begin([
        'id' => 'create-update-detalle-catedra-form','method' => 'post',]);
        foreach ($htrimprueba as $htx) {
            # code...
            $model = $htx;
            $salida .='<div class="row">';
            $salida .='<div class="col-md-3">'.$form->field($model, 'fecha')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'value' => $htx->fecha,
                'disabled' => true,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    //  'endDate' => "1d",
                    
                ],
                
            ])->label($dias2[date("w",strtotime($htx->fecha)-1)]).'</div>';
            $salida .='<div class="col-md-1" style="width:auto; padding-top:35px;"><span class="glyphicon glyphicon-arrow-right"></span></div>';
            $salida .='<div class="col-md-3">'.
            '<label class="lblmigracion"><b>'.$axt->aniolectivo0->nombre.' - '.$axt->trimestral0->nombre.'</b>'.
            DatePicker::widget([
                                'name' => $htx->fecha,
                                //'value' => '12/31/2010',
                                
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                    'startDate' => $axt->inicio,
                                    'endDate' => $axt->fin,
                                ],
                                'options' => [
                                    'style' => [
                                        'padding-top' => '10px']

                                ]
                            ])

            .'</label></div>';
            $salida .='</div>';
            $salida .='<hr />';
            $c++;
        }
        $salida .='</div>';
        $echodiv = $salida;

                      
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $keys = array_keys($params);
           
            $ch = 0;
            
            $nsm = 0;//no se migra
            $detalle = '<ul>';

            $horarios = Horarioexamen::find()
                ->andWhere(['anioxtrimestral' => $axtorigen->id])
                ->orderBy('fecha')
                ->all();
            
            foreach ($horarios as $horario) {

                    if($horario->catedra0->actividad != 195){ //no migra hora disponible
                        
                        $anioxtrimdesdemigrar = $horario->anioxtrimestral;
                        
                        try {
                            $horarionuevo = New Horarioexamen();
                            //$horarionuevo->scenario = $horario::SCENARIO_MIGRACIONHORARIO;
                            $horarionuevo->fecha = $params[$horario->fecha];
                            $horarionuevo->cambiada = 1;
                            $horarionuevo->tipo = $tipo;
                            $horarionuevo->anioxtrimestral = $axt->id;
                            $horarionuevo->catedra = $horario->catedra;
                            $horarionuevo->hora = $horario->hora;
                            $horarionuevo->catedra = $horario->catedra;
                            $horarionuevo->save();
                            $ch++;
                        } catch (ErrorException $e) {
                            $nsm ++;
                            $detalle .= "<li>{$horario->catedra0->division0->nombre} - {$horario->catedra0->actividad0->nombre}</li>";
                        }

                    }    
                        
                    /*elseif($tipo == 3){
                        $horarioexamenanterior = Horarioexamen::find()
                                    ->where(['catedra'=>$horario->catedra])
                                    ->andWhere(['tipo' => 3])
                                    ->one();
                        try {
                            $horarioexamenanterior->scenario = $horarioexamenanterior::SCENARIO_MIGRACIONHORARIO;             
                            $horarioexamenanterior->hora = $horarioexamenanterior->hora;
                            $horarioexamenanterior->anioxtrimestral =$axt->id;
                            $horarioexamenanterior->fecha = $params[$horario->fecha];
                            $horarioexamenanterior->cambiada = 2;
                            $horarioexamenanterior->save();
                            $ch++;
                        } catch (ErrorException $e) {
                            $nsm ++;
                            $detalle .= "<li>{$horario->catedra0->division0->nombre} - {$horario->catedra0->actividad0->nombre}</li>";
                        }
                        
                        
                    }*/
                    
                
            }
                
                $detalle .= '</ul>';
            
                        
            if($nsm>0){
                Yii::$app->session->setFlash('danger', "Se realizó la actualización de {$ch} horarios. Por superposiciones quedaron sin migrar {$nsm} horarios.<br />{$detalle}");
                    return $this->redirect(['/horarioexamen/index', 'id' => $anioxtrimdesdemigrar]);
            }else{
                Yii::$app->session->setFlash('success', "Se realizó la actualización de {$ch} horarios.");
            }
            
            return $this->redirect(['/horarioexamen/panelprincipal', 'col' => $col]);
            //return var_dump($keys);
        }


        return $this->render('migracionfechas', [
            
            
            'form' => $form,
            
            'echodiv' => $echodiv,
            'axt' => $axtorigen,
            'anioxtrimestral' => $anioxtrimestral,
            
        ]);
    }

    public function actionRevisarhorarios($id)
    {
        $axt = Anioxtrimestral::findOne($id);
        $tipo = ($axt->trimestral < 4) ? 2 : 3;
        $col =  ($tipo==2) ? 0 : 1;

        $searchModel = new HorarioexamenSearch();
        $providercursos = $searchModel->getSuperposicionCursos($id);

        $searchModel2 = new HorarioexamenSearch();
        $providerdocentes = $searchModel2->getSuperposicionDocentes($id);

        $searchModel3 = new HorarioexamenSearch();
        $providermaterias = $searchModel3->getMateriasNocargadas($id);

        return $this->render('revisarhorarios', [
            'providercursos' => $providercursos,
            'providerdocentes' => $providerdocentes,
            'providermaterias' => $providermaterias,
            'col' => $col,
        ]);
    }

    public function actionMesasxfecha($id)
    {
        $axt = Anioxtrimestral::findOne($id);
        $tipo = ($axt->trimestral < 4) ? 2 : 3;
        $col =  ($tipo==2) ? 0 : 1;

        $searchModel = new HorarioexamenSearch();
        $providercursos = $searchModel->porfecha($id);

        return $this->render('mesasxfecha', [
            'providercursos' => $providercursos,
        ]);
    }
}
