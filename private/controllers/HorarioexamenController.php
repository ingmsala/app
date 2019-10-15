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
use app\models\Docente;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Division;
use app\config\Globales;
use yii\data\ArrayDataProvider;
use app\models\DetallecatedraSearch;
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'menuxdivision', 'completoxcurso', 'completoxdia', 'completoxdocente', 'createdesdehorario', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'updatedesdehorario', 'filtropormateria', 'horariocompleto', 'print', 'printcursos', 'migracionfechas'],
                'rules' => [
                    [
                        'actions' => ['completoxdia', 'completoxdocente', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'filtropormateria', 'horariocompleto', 'printcursos'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION, Globales::US_PRECEPTORIA])){
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

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
                                        return true;
                                    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                                        
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

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_PRECEPTORIA, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
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
                        'actions' => ['index', 'createdesdehorario','updatedesdehorario', 'print', 'migracionfechas', 'delete'],   
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
    public function actionDelete($id)
    {
        $horarioexamen = $this->findModel($id);
        $anioxtrimestral = $horarioexamen->anioxtrimestral;
        $horarioexamen->delete();

        return $this->redirect(['index', 'id'=>$anioxtrimestral]);
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

    public function actionCompletoxcurso($division, $vista, $prt=0, $col=0){
        return $this->generarHorarioCurso($division, $vista, $prt, $col);
    }

    public function generarHorarioCurso($division, $vista, $prt, $col=0)
    {
        //$division = 1;
        //$dia = 3;

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioexamenSearch();
        $paramdivision = Division::findOne($division);
        $h= [];
        if($paramdivision->turno == 1){
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        }elseif ($paramdivision->turno == 2) {
            $h[1] = '13:30 a 14:30';
            $h[2] = '14:45 a 15:45';
            
        }
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
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->fecha, $tipo);
                                    
                                    if ($superpuesto[0]){
                                        if($cant>1){
                                            $superpuesto[1] = str_replace('</ul>', $horariox->catedra0->division0->nombre."</ul>", $superpuesto[1]);
                                        }
                                        ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else{
                                        if($cant>1){
                                            ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.'<ul>'.$horariox->catedra0->division0->nombre.'</ul>'.'">'.$dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1).'</span>'.'</span>';
                                        }else{
                                            $salida = $dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1);

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
        $dataProvider = $docente_materia_search->horario_doce_divi($division);

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
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

    public function horaSuperpuesta($dc, $hora, $fecha, $tipo){
        $docente = $dc->docente;
        $horarios = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'detallecatedra.id', $dc->id])
            ->andWhere(['horarioexamen.hora' => $hora])
            ->andWhere(['horarioexamen.fecha' => $fecha])
            ->andWhere(['horarioexamen.tipo' => $tipo])
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
           $model->save();

            return $this->redirect(['/horarioexamen/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'col' => $col]);
        }

        $division = Division::findOne($division);
        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->all();
        //$dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'tipos' => $tipos,
            'catedras' => $catedras,
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
            $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
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
            $infoexamen = "COLOQUIOS";
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
        $model = new Docente();
        $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        //$docentes = Docente::find()->select('id, LEFT(apellido, 1) AS inicial, apellido, nombre')->orderBy('apellido, nombre')->all();
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
            $id = Yii::$app->request->post()['Docente']['apellido'];
            return $this->redirect(['completoxdocente', 'docente' =>  $id]);
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
        $model = new Docente();
        $docentes = Docente::find()
            ->joinWith('detallecatedras')
            ->where(['like', 'apellido', $letra.'%', false])
            ->andWhere(['=', 'detallecatedra.revista', 6])
            ->orderBy('apellido, nombre')->all();
        

        $echodiv = '';
        foreach ($docentes as $doc) {
                $echodiv .= '<div class="pull-left" style="height: 21vh; width:29vh; vertical-align: middle;">';
                $echodiv .= '<div>';
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horarioexamen/completoxdocente&docente='.$doc->id.'&col='.$col.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
            'col' => $col,
            
        ]);
    }


    public function actionCompletoxdocente($docente, $col)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioexamenSearch();
        $docenteparam = Docente::findOne($docente);

        $h= [];
        $j= [];
        
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        
            $j[1] = '13:30 a 14:30';
            $j[2] = '14:45 a 15:45';

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
            
        
                
        $horariosTm = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horarioexamen.tipo' => $tipo])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        $horariosTt = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horarioexamen.tipo' => $tipo])
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

    public function generarFicha($docente, $col)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioexamenSearch();
        $docenteparam = Docente::findOne($docente);

        $h= [];
        $j= [];
        
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        
            $j[1] = '13:30 a 14:30';
            $j[2] = '14:45 a 15:45';
          
        if ($col == 0){
            $anioxtrim = Anioxtrimestral::find()
                            ->where(['activo' => 1])
                            ->andWhere(['<', 'trimestral', 4])
                            ->one();
            $tipo = 2;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha1print = Yii::$app->formatter->asDate($anioxtrim->inicio, 'dd/MM/yyyy');
            $fecha2print = Yii::$app->formatter->asDate($anioxtrim->fin, 'dd/MM/yyyy');
            $infocabecera = "Se comumica que los exámenes trimestrales correspondientes al <b>{$anioxtrimestral->trimestral0->nombre}</b> comenzarán el <b>{$fecha1print}</b> y teminarán el <b>{$fecha2print}</b>. Deberá entregarlos con las correciones pertinentes con un plazo máximo de <b><u>TRES DÍAS</u></b> siguientes a su recepción. Luego se archivarán en preceptoría.<br/>
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
        
                
        $horariosTm = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horarioexamen.tipo' => $tipo])
            ->orderBy('horarioexamen.fecha, horarioexamen.hora')
            ->all();

        $horariosTt = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horarioexamen.tipo' => $tipo])
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

    public function actionPrint($docente, $all, $col = 0){
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
            
            $docentes = Docente::find()
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
            $mat = Docente::findOne($docente);
            $salidaimpar = $this->generarFicha($docente, $col);
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
            'SetFooter'=>[date('d/m/Y').' - '.$filnamesinext ],
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
                $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
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

    public function actionMigracionfechas($anioxtrimestral){
        $axt = Anioxtrimestral::findOne($anioxtrimestral);
        
        
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if($axt->trimestral<4){
            $tipo = 2;
            $col = 0;
        }else{
            $tipo = 3;
            $col = 1;
        }

        $ht = Horarioexamen::find()
                ->select('fecha')
                ->distinct()
                ->where(['tipo' => 2])
                ->orderBy('fecha')
                ->all();


        $htexamen = Horarioexamen::find()
                ->select('fecha')
                ->distinct()
                ->where(['tipo' => 3])
                ->orderBy('fecha')
                ->all();

        if(count($htexamen)==0 && $tipo == 3){
            $nuevoexamen = true;
        }else{
            $nuevoexamen = false;
        }

        $salida = '';
        $salida .='<div class="content">';
        $c = 0;
        $form = ActiveForm::begin([
        'id' => 'create-update-detalle-catedra-form','method' => 'post',]);
        foreach ($ht as $htx) {
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

        $horariostr = Horarioexamen::find()
                ->where(['tipo' => 2])
                ->orderBy('fecha')
                ->all();

        if(count($horariostr)==0){
            return $this->redirect(['/anioxtrimestral']);
        }

        foreach ($horariostr as $htr) {
           $axtant = $htr->anioxtrimestral0;
           break;
        }

              
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $keys = array_keys($params);
            //return var_dump(Yii::$app->request->post());

            $horarios = Horarioexamen::find()
                ->where(['tipo' => 2])
                ->orderBy('fecha')
                ->all();

            
            
            $ch = 0;
            /*$transaction = Horarioexamen::getDb()->beginTransaction();
            try {
                foreach ($horarios as $horario) {

                    if($nuevoexamen){
                        $nuevohorarioexamen = new Horarioexamen();
                        $nuevohorarioexamen->scenario = $nuevohorarioexamen::SCENARIO_MIGRACIONHORARIO;
                        $nuevohorarioexamen->catedra = $horario->catedra;
                        $nuevohorarioexamen->hora = $horario->hora;
                        $nuevohorarioexamen->tipo = 3;
                        $nuevohorarioexamen->anioxtrimestral =$axt->id;
                        $nuevohorarioexamen->fecha = $params[$horario->fecha];
                        $nuevohorarioexamen->cambiada = 2;
                        
                        $nuevohorarioexamen->save();

                    }else{
                        if($tipo == 2){
                            $horario->scenario = $horario::SCENARIO_MIGRACIONHORARIO;
                            $horario->fecha = $params[$horario->fecha];
                            $horario->cambiada = 2;
                            $horario->anioxtrimestral =$axt->id;
                            $horario->save();
                        }elseif($tipo == 3){
                            $horarioexamenanterior = Horarioexamen::find()
                                        ->where(['catedra'=>$horario->catedra])
                                        ->andWhere(['tipo' => 3])
                                        ->one();
                            $horarioexamenanterior->scenario = $horarioexamenanterior::SCENARIO_MIGRACIONHORARIO;             
                            $horarioexamenanterior->hora = $horarioexamenanterior->hora;
                            $horarioexamenanterior->anioxtrimestral =$axt->id;
                            $horarioexamenanterior->fecha = $params[$horario->fecha];
                            $horarioexamenanterior->cambiada = 2;
                            $horarioexamenanterior->save();
                            
                        }
                        
                    }

                    
                     $ch++;
                     //return var_dump($horario);
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

            foreach ($horarios as $horario) {
                $horario->scenario = $horario::SCENARIO_MIGRACIONHORARIO2;
                $horario->cambiada = 1;
                $horario->save();

            }*/

                $nsm = 0;
                $detalle = '<ul>';
            
                foreach ($horarios as $horario) {

                    if($ch == 0)
                        $anioxtrimdesdemigrar = $horario->anioxtrimestral;

                    if($nuevoexamen){
                        $nuevohorarioexamen = new Horarioexamen();
                        try {
                            $nuevohorarioexamen->scenario = $nuevohorarioexamen::SCENARIO_MIGRACIONHORARIO;
                            $nuevohorarioexamen->catedra = $horario->catedra;
                            $nuevohorarioexamen->hora = $horario->hora;
                            $nuevohorarioexamen->tipo = 3;
                            $nuevohorarioexamen->anioxtrimestral =$axt->id;
                            $nuevohorarioexamen->fecha = $params[$horario->fecha];
                            $nuevohorarioexamen->cambiada = 2;
                            $nuevohorarioexamen->save();
                            $ch++;
                        } catch (ErrorException $e) {
                            $nsm ++;
                            $detalle .= "<li>{$horario->catedra0->division0->nombre} - {$horario->catedra0->actividad0->nombre}</li>";
                        }
                            
                        
                        

                    }else{
                        if($tipo == 2){
                            try {
                                $horario->scenario = $horario::SCENARIO_MIGRACIONHORARIO;
                                $horario->fecha = $params[$horario->fecha];
                                $horario->cambiada = 2;
                                $horario->anioxtrimestral =$axt->id;
                                $horario->save();
                                $ch++;
                            } catch (ErrorException $e) {
                               $nsm ++;
                               $detalle .= "<li>{$horario->catedra0->division0->nombre} - {$horario->catedra0->actividad0->nombre}</li>";
                            }

                            
                            
                        }elseif($tipo == 3){
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
                            
                            
                        }
                        
                    }

                    
                    
                     //return var_dump($horario);
                }
                
                $detalle .= '</ul>';
            
            $horarios = Horarioexamen::find()
                ->where(['tipo' => $tipo])
                ->andWhere(['cambiada' => 2])
                ->orderBy('fecha')
                ->all();

            foreach ($horarios as $horario) {
                $horario->scenario = $horario::SCENARIO_MIGRACIONHORARIO2;
                $horario->cambiada = 1;
                $horario->save();

            }
            
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
            'axt' => $axtant,
            'anioxtrimestral' => $anioxtrimestral,
            
        ]);
    }
}
