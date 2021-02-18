<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\Catedra;
use app\models\Clasevirtual;
use app\models\ClasevirtualSearch;
use app\models\DetallecatedraSearch;
use app\models\Division;
use app\models\Agente;
use app\models\Hora;
use app\models\Preceptoria;
use app\models\Semana;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * ClasevirtualController implements the CRUD actions for Clasevirtual model.
 */
class ClasevirtualController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clasevirtual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClasevirtualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clasevirtual model.
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
     * Creates a new Clasevirtual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clasevirtual();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clasevirtual model.
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
     * Deletes an existing Clasevirtual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id, $h=0)
    {
        $clasevirtual = $this->findModel($id);
        $semana = $clasevirtual->semana;
        $division = $clasevirtual->catedra0->division;
        
        $clasevirtual->delete();
        
        return $this->redirect(['/clasevirtual/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'prt'=>0, 'sem'=>$semana]);
        
        
    }
   

    /**
     * Finds the Clasevirtual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clasevirtual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clasevirtual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCompletoxcurso($division, $vista, $prt=0, $sem=1, $ini=0){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        if($ini == 1)
        {    $semana = Semana::find()
                        ->where(['<','inicio',date('Y-m-d')])
                        ->andWhere(['>','fin',date('Y-m-d')])
                        ->one();
            
            if($semana == null){
                $semana = Semana::find()
                        ->where(['>','inicio',date('Y-m-d')])
                        ->all();
                $sem = min($semana)->id;
            }else
                $sem= $semana->id;
        }
        
        return $this->generarHorarioCurso($division, $vista, $prt, $sem);
    }

    public function actionCompletoxdocente($docente, $prt=0, $sem=1, $ini=0){

        if($ini == 1)
        {    $semana = Semana::find()
                        ->where(['<','inicio',date('Y-m-d')])
                        ->andWhere(['>','fin',date('Y-m-d')])
                        ->one();
            
            if($semana == null){
                $semana = Semana::find()
                        ->where(['>','inicio',date('Y-m-d')])
                        ->all();
                $sem = min($semana)->id;
            }else
                $sem= $semana->id;
        }
        
        return $this->generarHorarioDocente($docente, $prt, $sem);
    }

    public function generarHorarioCurso($division, $vista, $prt, $sem=0)
    {
        //$division = 1;
        //$dia = 3;

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new ClasevirtualSearch();
        $paramdivision = Division::findOne($division);
        $h= [];
        if($paramdivision->turno == 1){
            $h[1] = '8:00 a 9:00';
            $h[2] = '9:00 a 10:00';
            $h[3] = '10:00 a 11:00';
            
        }elseif ($paramdivision->turno == 2) {
            $h[1] = '14:00 a 15:00';
            $h[2] = '15:00 a 16:00';
            $h[3] = '16:00 a 17:00';
            
        }

        $semana = Semana::findOne($sem);

        try {
            $sema = Semana::findOne($sem-1);
        } catch (\Throwable $th) {
            $sema = null;
        }

        try {
            $semn = Semana::findOne($sem+1);
        } catch (\Throwable $th) {
            $semn = null;
        }
        
       

        

        if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $semana->publicada == 0){
            Yii::$app->session->setFlash('danger', "No se encuentra publicada la semana");
            return $this->redirect(['clasevirtual', 'sem' => 0]);
        }
        
        $horarios = Clasevirtual::find()
            ->joinWith(['catedra0'])
            ->where(['semana' => $semana->id])
            ->andWhere(['catedra.division' => $division])
            ->orderBy('fecha')
            ->all();

        $start = $semana->inicio;
        $end = $semana->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        //return var_dump($range);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3,4]])->all();
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
                            $array[$hora->id][$fechats] = '<a class="btn btn-info btn-sm" href="?r=clasevirtual/createdesdehorario&division='.$division.'&hora='.$hora->id.'&fecha='.$fechats.'&semana='.$semana->id.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
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
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->fecha);
                                    
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
                        $array[$horariox->hora][$horariox->fecha] = '<a class="btn btn-link btn-sm" href="?r=clasevirtual/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&fecha='.$horariox->fecha.'&semana='.$semana->id.'">'.$salida.'</a>';
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
        $dataProvider = $docente_materia_search->horario_doce_divi($division, 2);

        /*if($prt == 1)
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

            ]);*/
        return $this->render('completoxcurso', [
            //'model' => $model,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'paramdivision' => $paramdivision,
            'vista' => $vista,
            'diasgrid' => $diasgrid,
            'al' => $semana->aniolectivo,
            'semana' => $semana,
            'prt' => $prt,
            'listdc' => $listdc,
            'sem' => $sem,
            'sema' => $sema,
            'semn' => $semn,

        ]);
    }

    public function horaSuperpuesta($dc, $hora, $fecha){
        $docente = $dc->agente;
        $horarios = Clasevirtual::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'detallecatedra.id', $dc->id])
            ->andWhere(['clasevirtual.hora' => $hora])
            ->andWhere(['clasevirtual.fecha' => $fecha])
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

    public function actionCreatedesdehorario($division, $hora, $fecha, $semana)
    {
        $model = new Clasevirtual();
        //$model->scenario = $model::SCENARIO_CREATEHORARIO;
        $model->hora = $hora;
        $model->fecha = $fecha;
        $model->semana = $semana;

        if ($model->load(Yii::$app->request->post())) {


            $model->save();
            return $this->redirect(['/clasevirtual/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
        }

        

        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->where(['in', 'id', [2,3,4]])->all();
        $division = Division::findOne($division);
        
        return $this->render('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'catedras' => $catedras,
        ]);
    }

    public function actionUpdatedesdehorario($division, $hora, $fecha, $semana)
    {
        $model = Clasevirtual::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['hora' => $hora])
                    ->andWhere(['semana' => $semana])
                    ->andWhere(['fecha' => $fecha])
                    ->one();
        

        if ($model->load(Yii::$app->request->post())) {
           //    $model->catedra = $model->catedra;

            //$model->anioxtrimestral = $alxtrim;
 
           $model->save();

            return $this->redirect(['/clasevirtual/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
        }

        $division = Division::findOne($division);
        $catedras = Catedra::find()->where(['division' => $division->id])->all();
        $horas = Hora::find()->all();
        //$dias = Diasemana::find()->all();
        
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            
            'catedras' => $catedras,
            
        ]);
    }

    public function actionPrintcursos($division, $all, $sem = 0){
        //$this->layout = 'print';
        
        $semana = Semana::findOne($sem);

        
        /*if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $semana->publicada ==0){
            Yii::$app->session->setFlash('danger', "No se encuentra publicada la semana");*/
            //return $this->redirect(['/clase/panelprincipal', 'col' => $col]);
            
        
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
                $salidaimpar .= $this->generarHorarioCurso($divi->id, 'materias', 1, $semana->id);
            
            }
            $filenamesext = "{$semana->aniolectivo0->nombre} - Horario Completo - {$semana->inicio}";
            $filename = $filenamesext.".pdf";
        }else{
            $di = Division::findOne($division);
            $salidaimpar = $this->generarHorarioCurso($division, 'materias', 1, $semana->id);
            $filenamesext = "{$semana->aniolectivo0->nombre} - Horario {$semana->inicio} - {$di->nombre}";
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

    public function actionMenuxsemana()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        $semanas = Semana::find()->where(['aniolectivo' => 2])->all();
      
        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_REGENCIA])){
            $vista = 'docentes';
        }else{
            $vista = 'materias';
        }
        
        $echodiv = '';
        foreach ($semanas as $semana) {

            $echodiv .= '<div class="pull-left" style="height: 16vh; width: 37vh; vertical-align: middle;">';
            $echodiv .= '<div>';
            $echodiv .= '<center><a class="menuHorarios" href="index.php?r=clasevirtual/panelprincipal&semana='.$semana->id.'&vista='.$vista.'" role="button" style="font-size:4vh; width:30vh; height: 15vh;">'.$semana->inicio.'</a>';
            $echodiv .= '</div><center>';
            $echodiv .= '</div>';

               
        }
        return $this->render('menuxsemana', [
            'echodiv' => $echodiv,
            
        ]);
    }

    public function actionPanelprincipal()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        
        $infoexamen = "CLASES VIRTUALES";
        
        return $this->render('panelprincipal', [
            'infoexamen' => $infoexamen,
            
        ]);
    }

    
    public function actionMenuxdivision($col = 0)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

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
                $echodiv .= '<a class="menuHorarios" href="index.php?r=clasevirtual/completoxcurso&division='.$division->id.'&vista='.$vista.'&prt=0&ini=1'.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivision', [
            'echodiv' => $echodiv,
            
        ]);
    }

    public function actionMenuxletra()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        
        $model = new Agente();
        $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        //$docentes = Agente::find()->select('id, LEFT(apellido, 1) AS inicial, apellido, nombre')->orderBy('apellido, nombre')->all();
        $echodiv = '';
        $echodiv .= '<div class="row">';
        foreach ($abecedario as $letra) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=clasevirtual/menuxdocenteletra&letra='.$letra.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
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
            
            
        ]);
    }

    public function actionMenuxdocenteletra($letra)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';

        
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
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=clasevirtual/completoxdocente&docente='.$doc->id.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
           
            
        ]);
    }

    public function generarHorarioDocente($docente, $prt, $sem=1)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
       
        $docenteparam = Agente::findOne($docente);

        $h= [];
        $j= [];

        $semana = Semana::findOne($sem);

        try {
            $sema = Semana::findOne($sem-1);
        } catch (\Throwable $th) {
            $sema = null;
        }

        try {
            $semn = Semana::findOne($sem+1);
        } catch (\Throwable $th) {
            $semn = null;
        }
        
        $h[1] = '8:00 a 9:00';
        $h[2] = '9:00 a 10:00';
        $h[3] = '10:00 a 11:00';
            
        
        $j[1] = '14:00 a 15:00';
        $j[2] = '15:00 a 16:00';
        $j[3] = '16:00 a 17:00';

                  
        
                
        $horariosTm = Clasevirtual::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['clasevirtual.semana' => $sem])
            ->orderBy('clasevirtual.fecha, clasevirtual.hora')
            ->all();

        $horariosTt = Clasevirtual::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['clasevirtual.semana' => $sem])
            ->orderBy('clasevirtual.fecha, clasevirtual.hora')
            ->all();

        
        
        $start = $semana->inicio;
        $end = $semana->fin;

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        $dias = $range;
        $horas = Hora::find()->where(['in', 'id', [2,3,4]])->all();
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
                    $arrayTm[$horarioxTm->hora][$horarioxTm->fecha] .= '<a href="'.$horarioxTm->catedra0->division0->enlaceclase.'" target="_blank">'.$horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</a>';//Html::a(, 'https://'.$horarioxTm->catedra0->division0->enlaceclase, $options = []);//'<a href="'.Url::to($horarioxTm->catedra0->division0->enlaceclase).'">'.$horarioxTm->catedra0->division0->nombre.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</a>';
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
                    $arrayTt[$horarioxTt->hora][$horarioxTt->fecha] .= '<a href="'.$horarioxTt->catedra0->division0->enlaceclase.'" target="_blank">'.$horarioxTt->catedra0->division0->nombre.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</a>';
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
            'semana' => $semana,
            'sema' => $sema,
            'semn' => $semn,
            
        ]);
    }

    public function actionGoto($url){
        header('Location: '.$url);
     exit();
    }
}   


