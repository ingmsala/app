<?php

namespace app\controllers;

use Yii;
use app\models\Horariotrimestral;
use app\models\HorariotrimestralSearch;
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

/**
 * HorariotrimestralController implements the CRUD actions for Horariotrimestral model.
 */
class HorariotrimestralController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'menuxdivision', 'completoxcurso', 'completoxdia', 'completoxdocente', 'createdesdehorario', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'updatedesdehorario', 'filtropormateria', 'horariocompleto'],
                'rules' => [
                    [
                        'actions' => ['completoxdia', 'completoxdocente', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'filtropormateria', 'horariocompleto'],   
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
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
                        'actions' => ['createdesdehorario','updatedesdehorario'],   
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
     * Lists all Horariotrimestral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HorariotrimestralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horariotrimestral model.
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
     * Creates a new Horariotrimestral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horariotrimestral();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Horariotrimestral model.
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
     * Deletes an existing Horariotrimestral model.
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
     * Finds the Horariotrimestral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horariotrimestral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horariotrimestral::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCompletoxcurso($division, $vista, $prt=0){
        return $this->generarHorarioCurso($division, $vista, $prt);
    }

    public function generarHorarioCurso($division, $vista, $prt)
    {
        //$division = 1;
        //$dia = 3;

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioTrimestralSearch();
        $paramdivision = Division::findOne($division);
        $h= [];
        if($paramdivision->turno == 1){
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        }elseif ($paramdivision->turno == 2) {
            $h[1] = '13:30 a 14:30';
            $h[2] = '14:45 a 15:45';
            
        }

        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
            }
        }

        $horarios = Horariotrimestral::find()
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
                            $array[$hora->id][$fechats] = '<a class="btn btn-info btn-sm" href="?r=horariotrimestral/createdesdehorario&division='.$division.'&hora='.$hora->id.'&fecha='.$fechats.'&tipo=2&alxtrim='.$anioxtrim->id.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
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
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->fecha);
                                    if ($superpuesto[0]){
                                        ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else
                                        $salida = $dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1);
                                    $listdc[] = $dc->id;
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
                        $array[$horariox->hora][$horariox->fecha] = $salida.'<div class="pull-right"><a class="btn btn-success btn-sm" href="?r=horariotrimestral/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&fecha='.$horariox->fecha.'&tipo=2&alxtrim='.$anioxtrim->id.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>';
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
                'trimestral' => $anioxtrim->trimestral,
                'prt' => $prt,
                'listdc' => $listdc,

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
            'trimestral' => $anioxtrim->trimestral,
            'prt' => $prt,
            'listdc' => $listdc,

        ]);
    }

    public function actionCreatedesdehorario($division, $hora, $fecha, $tipo, $alxtrim)
    {
        $model = new Horariotrimestral();
        //$model->scenario = $model::SCENARIO_CREATEHORARIO;
        $model->hora = $hora;
        $model->fecha = $fecha;
        $model->tipo = $tipo;
        $model->anioxtrimestral = $alxtrim;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
               return $this->redirect(['/horariotrimestral/completoxcurso', 'division' => $division, 'vista' => 'docentes']);
        }

        

        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        //$dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            //'dias' => $dias,
            'tipos' => $tipos,
            'catedras' => $catedras,
        ]);
    }

    public function horaSuperpuesta($dc, $hora, $fecha){
        $docente = $dc->docente;
        $horarios = Horariotrimestral::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'detallecatedra.id', $dc->id])
            ->andWhere(['horariotrimestral.hora' => $hora])
            ->andWhere(['horariotrimestral.fecha' => $fecha])
            ->andWhere(['horariotrimestral.tipo' => 2])
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

    public function actionUpdatedesdehorario($division, $hora, $fecha, $tipo, $alxtrim)
    {
        $model = Horariotrimestral::find()
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

            return $this->redirect(['/horariotrimestral/completoxcurso', 'division' => $division, 'vista' => 'docentes']);
        }

        
        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->all();
        //$dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            //'dias' => $dias,
            'tipos' => $tipos,
            'catedras' => $catedras,
        ]);
    }

    public function actionMenuxdivision()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
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
        
        $echodiv = '';
        foreach ($divisiones as $division) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horariotrimestral/completoxcurso&division='.$division->id.'&vista=docentes&prt=0" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivision', [
            'echodiv' => $echodiv,
        ]);
    }

    public function actionPanelprincipal()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        return $this->render('panelprincipal');
    }
    public function actionMenuxletra()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
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
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horariotrimestral/menuxdocenteletra&letra='.$letra.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
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
            
        ]);
    }

    public function actionMenuxdocenteletra($letra)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
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
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horariotrimestral/completoxdocente&docente='.$doc->id.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
            
        ]);
    }


    public function actionCompletoxdocente($docente)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorariotrimestralSearch();
        $docenteparam = Docente::findOne($docente);

        $h= [];
        $j= [];
        
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        
            $j[1] = '13:30 a 14:30';
            $j[2] = '14:45 a 15:45';
            
        
                
        $horariosTm = Horariotrimestral::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariotrimestral.tipo' => 2])
            ->orderBy('horariotrimestral.fecha, horariotrimestral.hora')
            ->all();

        $horariosTt = Horariotrimestral::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariotrimestral.tipo' => 2])
            ->orderBy('horariotrimestral.fecha, horariotrimestral.hora')
            ->all();

        $anioxtrimestral = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrimestral == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
            }
        }


        $start = $anioxtrimestral->inicio;
        $end = $anioxtrimestral->fin;

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
            'anioxtrimestral' => $anioxtrimestral,
            
        ]);
    }

    public function generarFicha($docente)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorariotrimestralSearch();
        $docenteparam = Docente::findOne($docente);

        $h= [];
        $j= [];
        
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:15 a 10:15';
            
        
            $j[1] = '13:30 a 14:30';
            $j[2] = '14:45 a 15:45';
            
        
                
        $horariosTm = Horariotrimestral::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariotrimestral.tipo' => 2])
            ->orderBy('horariotrimestral.fecha, horariotrimestral.hora')
            ->all();

        $horariosTt = Horariotrimestral::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariotrimestral.tipo' => 2])
            ->orderBy('horariotrimestral.fecha, horariotrimestral.hora')
            ->all();

        $anioxtrimestral = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrimestral == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
            }
        }

        $start = $anioxtrimestral->inicio;
        $end = $anioxtrimestral->fin;

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
            'anioxtrimestral' => $anioxtrimestral,
            
        ]);
    }

    public function actionPrint($docente, $all){
        //$this->layout = 'print';
        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
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
            $salidaimpar .= $this->generarFicha($doc->id);
            
            }
           
            $filename = "Citaciones Trimestral".".pdf";
        }else{
            $mat = Docente::findOne($docente);
            $salidaimpar = $this->generarFicha($docente);
            $filename = $mat->apellido.'_'.$mat->nombre.'.pdf';
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
                .horariotrimestral-view{
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
            'SetFooter'=>[date('d/m/Y').' - Citación de Examen Trimestral - '.$filename ],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }

    public function actionPrintcursos($division, $all){
        //$this->layout = 'print';
        $anioxtrim = Anioxtrimestral::find()
                        ->where(['activo' => 1])->one();

        if($anioxtrim == null){
            Yii::$app->session->setFlash('danger', "No se encuentra activo el horario a trimestrales");
            return $this->redirect(['/horariotrimestral/panelprincipal']);
        }else{
            if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $anioxtrim->publicado !=1){
                Yii::$app->session->setFlash('danger', "No se encuentra publicado el horario de los exámenes trimestrales");
                return $this->redirect(['/horariotrimestral/panelprincipal']);
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
                $salidaimpar .= $this->generarHorarioCurso($divi->id, 'materias', 1);
            
            }
           
            $filename = "Horario Trimestral".".pdf";
        }else{
            $di = Division::findOne($division);
            $salidaimpar = $this->generarHorarioCurso($division, 'materias', 1);
            $filename = $di->nombre.'.pdf';
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
            'SetFooter'=>[date('d/m/Y').' - Horario de Examenes Trimestrales - '.$filename ],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    
    return $pdf->render(); 
    }

    public function actionMigracionfechas($anioxtrimestral){
        $axt = Anioxtrimestral::findOne($anioxtrimestral);
        
        $diasgridtm = [];
        $diasgridtm['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgridtm['columns'][] =[
                        'label' => 'Fecha actual activa',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'value' => function($model){
                            //return var_dump($model);

                            return DatePicker::widget([
                                'name' => 'birth_date',
                                'value' => $model->fecha,
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'disable' => 'disable',
                                    'format' => 'dd/mm/yyyy'
                                ]
                            ]);
                        }
                        
                    ];
        $diasgridtm['columns'][] =[
                        'label' => '',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'value' => function (){return '<span class="glyphicon glyphicon-arrow-right"></span>';},
                        
                    ];
        $diasgridtm['columns'][] =[
                        'label' => $axt->aniolectivo0->nombre.' - '.$axt->trimestral0->nombre,
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'value' => function($model) use ($axt){
                            //return var_dump($model);

                            return DatePicker::widget([
                                'name' => $model->fecha,
                                //'value' => '12/31/2010',
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                    'startDate' => $axt->inicio,
                                    'endDate' => $axt->fin,
                                ]
                            ]);
                        }
                        
                        
                    ];
        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        $ht = Horariotrimestral::find()
                ->select('fecha')
                ->distinct()
                ->orderBy('fecha')
                ->all();

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
            '<label><b>'.$axt->aniolectivo0->nombre.' - '.$axt->trimestral0->nombre.'</b>'.
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

        /*foreach ($ht as $htx) {
            $ch = 0;
            $fechats = $htx;

           
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $dia = Yii::$app->formatter->asDate($htx, 'dd/MM/yyyy');

            

            $salida = '';
        foreach ($horariosTm as $horarioxTm) {
                
                if($arrayTm[$horarioxTm->hora][$horarioxTm->fecha] != ''){
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= ' - '.'<span style="color:red;">';
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
        
                }else{
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre;
                }
                
        }*/


        $query = '';
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $keys = array_keys($params);
            //return var_dump(Yii::$app->request->post());

            $horarios = Horariotrimestral::find()
                ->orderBy('fecha')
                ->all();
            $query = '';

            foreach ($horarios as $horario) {
                //$horario->fecha = $params[$horario->fecha];
                 $horario->cambiada =1;
                 $horario->anioxtrimestral =$axt->id;
                $horario->save();
                 //return var_dump($horario);
            }

            foreach ($keys as $fechaactual) {
               if($fechaactual != "_csrf" && $fechaactual != "Horariotrimestral"){
                    $sal = $params[$fechaactual];
                    $query .= "update horariotr set {$fechaactual} = {$sal}";
               }
                

            }
            return $query;
            return var_dump($keys);
        }


        $providerTm = new ArrayDataProvider([
            'allModels' => $ht,
            
        ]);
        return $this->render('migracionfechas', [
            
            'providerTm' => $providerTm,
            'form' => $form,
            
            'diasgridtm' => $diasgridtm,
            'echodiv' => $echodiv,
            'anioxtrimestral' => $anioxtrimestral,
            
        ]);
    }
}
