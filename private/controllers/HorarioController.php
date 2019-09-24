<?php

namespace app\controllers;

use Yii;
use app\models\Horario;
use app\models\HorarioSearch;
use app\models\DetallecatedraSearch;
use app\models\Hora;
use app\models\Division;
use app\models\Catedra;
use app\models\Docente;
use app\models\Diasemana;
use app\models\Tipoparte;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * HorarioController implements the CRUD actions for Horario model.
 */
class HorarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
   public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'menuxdivision', 'completoxcurso', 'completoxdia', 'completoxdocente', 'createdesdehorario', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'updatedesdehorario'],
                'rules' => [
                    [
                        'actions' => ['menuxdivision', 'completoxcurso', 'completoxdia', 'completoxdocente', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA])){
                                        return true;
                                    }

                                    return false;

                                    
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO]);
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
     * Lists all Horario models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new HorarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPanelprincipal()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        return $this->render('panelprincipal');
    }

    public function actionMenuxdivision()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $divisiones = Division::find()
        				->where(['in', 'turno', [1,2]])
        				->orderBy('id')
        				->all();
        $echodiv = '';
        foreach ($divisiones as $division) {
        		$echodiv .= '<div class="col-md-1 col-lg-1 col-sm-1 col-lx-1" style="height: 16vh; width: 16vh; vertical-align: middle;">';
        		$echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$division->id.'&vista=docentes" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivision', [
        	'echodiv' => $echodiv,
        ]);
    }

     public function actionMenuxdia()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $dias = Diasemana::find()
                        ->where(['not in', 'id', [1,7]])
                        ->orderBy('id')
                        ->all();
        $echodiv = '';
        foreach ($dias as $dia) {
                $echodiv .= '<div class="col-md-3 col-lg-3 col-sm-3 col-lx-3" style="height: 16vh; vertical-align: middle;">';
                $echodiv .= '<div>';
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horario/completoxdia&dia='.$dia->id.'&vista=docentes" role="button" style="font-size:5vh; width:30vh; height: 15vh;">'.$dia->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdia', [
            'echodiv' => $echodiv,
        ]);
    }
    /**
     * Displays a single Horario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Horario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($catedra)
    {

        $model = new Horario();
        $model->scenario = $model::SCENARIO_CREATEHORARIO;

        if ($model->load(Yii::$app->request->post())) {
        	//$model->catedra = $catedra;


        	try{
                 $largo = count($model->hora);
             }catch(\Exception $exception){
                $largo = 0;
            }
            $horas = $model->hora;
            $tr = true;
            for ($i=0; $i < $largo; $i++) { 
            	$model2 = new Horario();
                $model2->catedra = $catedra;
                $model2->tipo = $model->tipo;
                $model2->diasemana = $model->diasemana;
                $model2->hora = $horas[$i];
                
                $valid = $model2->validate();
                if($valid){
                	
                	$model2->save();
                }else{
                    $tr = false;
                    $model->addError('tipo', 'Ya está asignada la hora');
                    //return \yii\widgets\ActiveForm::validate($model);
                    //Yii::$app->session->setFlash('error','err');
                }
            }

            if($tr)
        	   return $this->redirect(['/catedra/view', 'id' => $catedra]);
        }

        $horas = Hora::find()->all();
        $dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('create', [
            'model' => $model,
            'horas' => $horas,
            'dias' => $dias,
            'tipos' => $tipos,
        ]);
    }

    public function actionCreatedesdehorario($division, $hora, $diasemana, $tipo)
    {
        $model = new Horario();
        $model->scenario = $model::SCENARIO_CREATEHORARIO;
        $model->hora = $hora;
            $model->diasemana = $diasemana;
            $model->tipo = $tipo;

        if ($model->load(Yii::$app->request->post())) {
            //$model->catedra = $catedra;



            try{
                 $largo = count($model->hora);
             }catch(\Exception $exception){
                $largo = 0;
            }
            $horas = $model->hora;
            $tr = true;
            for ($i=0; $i < $largo; $i++) { 
                $model2 = new Horario();
                $model2->catedra = $model->catedra;
                $model2->tipo = $model->tipo;
                $model2->diasemana = $model->diasemana;
                $model2->hora = $horas[$i];
                //return var_dump($model2);
                $valid = $model2->validate();
                if($valid){
                    
                    $model2->save();
                }else{
                    $tr = false;
                    $model->addError('tipo', 'Ya está asignada la hora');
                    //return \yii\widgets\ActiveForm::validate($model);
                    //Yii::$app->session->setFlash('error','err');
                }
            }

            if($tr)
               return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes']);
        }

        

        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->all();
        $dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'dias' => $dias,
            'tipos' => $tipos,
            'catedras' => $catedras,
        ]);
    }

    public function actionUpdatedesdehorario($division, $hora, $diasemana, $tipo)
    {
        $model = Horario::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['hora' => $hora])
                    ->andWhere(['diasemana' => $diasemana])
                    ->andWhere(['tipo' => $tipo])
                    ->one();
        

        if ($model->load(Yii::$app->request->post())) {
           //    $model->catedra = $model->catedra;


           $model->save();

            return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes']);
        }

        
        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Hora::find()->all();
        $dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'dias' => $dias,
            'tipos' => $tipos,
            'catedras' => $catedras,
        ]);
    }
    /**
     * Updates an existing Horario model.
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
     * Deletes an existing Horario model.
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

    public function actionCompletoxcurso($division, $vista)
    {
    	//$division = 1;
    	//$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
    	$searchModel = new HorarioSearch();
        $paramdivision = Division::findOne($division);
        $h= [];
        if($paramdivision->turno == 1){
            $h[1] = '7:15 a 7:55';
            $h[2] = '8:00 a 8:40';
            $h[3] = '8:45 a 9:25';
            $h[4] = '9:30 a 10:10';
            $h[5] = '10:20 a 11:00';
            $h[6] = '11:05 a 11:45';
            $h[7] = '11:50 a 12:30';
            $h[8] = '12:35 a 13:15';
        }elseif ($paramdivision->turno == 2) {
            $h[1] = '13:30 a 14:10';
            $h[2] = '14:15 a 14:55';
            $h[3] = '15:00 a 15:40';
            $h[4] = '15:45 a 16:25';
            $h[5] = '16:35 a 17:15';
            $h[6] = '17:20 a 18:00';
            $h[7] = '18:05 a 18:45';
            $h[8] = '18:50 a 19:30';
        }
        $horarios = Horario::find()
        	->joinWith(['catedra0'])
        	//->where(['diasemana' => 2])
        	->andWhere(['catedra.division' => $division])
        	->andWhere(['tipo' => 1])
        	->orderBy('diasemana, hora')
        	->all();

        $dias = Diasemana::find()->where(['not in', 'id',[1,7] ])->all();
        $horas = Hora::find()->all();
        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        foreach ($dias as $dia) {
			$ch = 0;
        	foreach ($horas as $hora) {
        		# code...
                if($cd == 0)
                    $array[$hora->id][$cd] = $h[$ch+1]; 
                if (Yii::$app->user->identity->role != Globales::US_HORARIO)
        		  $array[$hora->id][$dia->id] = '<a class="btn btn-info btn-sm" href="?r=horario/createdesdehorario&division='.$division.'&hora='.$hora->id.'&diasemana='.$dia->id.'&tipo=1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                else
                    $array[$hora->id][$dia->id] = "-";
        		//$key = array_search($hora->id, array_column($horarios, 'hora'));
        		//$salida .= $key;
        		/*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

        		
        		}*/
        		$ch = $ch + 1;
        	}
        	$cd = $cd + 1;
        }
        $salida = '';
        foreach ($horarios as $horariox) {
        	
		                	foreach ($horariox->catedra0->detallecatedras as $dc) {

		                		$salida = '';
		                		if ($dc->revista == 6){
		                			//return var_dump($dc['revista']==1);
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->diasemana);
                                    if ($superpuesto[0]){
                                        ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else
                                        $salida = $dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1);
		                			break 1;
		                		}else{
		                			$salida = 'ss';
		                		}
		                	}
		                   //return $salida;
		    if($vista == 'docentes'){
                if (Yii::$app->user->identity->role != Globales::US_HORARIO)
                    $array[$horariox->hora][$horariox->diasemana] = $salida.'<div class="pull-right"><a class="btn btn-success btn-sm" href="?r=horario/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&diasemana='.$horariox->diasemana.'&tipo=1"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>';
                else
                    $array[$horariox->hora][$horariox->diasemana] = $salida;
            }else
        		$array[$horariox->hora][$horariox->diasemana] = $horariox->catedra0->actividad0->nombre;
        }

        $provider = new ArrayDataProvider([
	        'allModels' => $array,
	        
	    ]);
		//return var_dump($array);

        $docente_materia_search = new DetallecatedraSearch();
        $dataProvider = $docente_materia_search->horario_doce_divi($division);

        return $this->render('completoxcurso', [
            //'model' => $model,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'paramdivision' => $paramdivision,
            'vista' => $vista,
        ]);
    }

    public function horaSuperpuesta($dc, $hora, $diasemana){
        $docente = $dc->docente;
        $horarios = Horario::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            ->where(['detallecatedra.docente' => $docente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'detallecatedra.id', $dc->id])
            ->andWhere(['horario.hora' => $hora])
            ->andWhere(['horario.diasemana' => $diasemana])
            ->andWhere(['horario.tipo' => 1])
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


    public function actionCompletoxdia($dia, $vista)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioSearch();
        $paramdia = Diasemana::findOne($dia);
        
        
        $horarios = Horario::find()
            ->joinWith(['catedra0'])
            ->where(['diasemana' => $dia])
            //->andWhere(['catedra.division' => $division])
            ->andWhere(['tipo' => 1])
            ->orderBy('diasemana, hora')
            ->all();

        $divisiones = Division::find()->where(['in', 'turno', [1,2] ])->all();
        $horas = Hora::find()->all();
        $cd = 0;
        //return var_dump($dias);
        
        $arrayaux = [];

        $salida = '';
        foreach ($divisiones as $division) {
            $ch = 0;
            foreach ($horas as $hora) {

                if($ch == 0)
                    $arrayaux[$division->id][$ch+1] = $division->nombre;

                $ch = $ch + 1;
                

                $arrayaux[$division->id][$hora->id] = '-';

                                
            }
            
        }
        $salida = '';
        foreach ($horarios as $horariox) {
            
                            foreach ($horariox->catedra0->detallecatedras as $dc) {

                                $salida = '';
                                if ($dc->revista == 6){
                                    //return var_dump($dc['revista']==1);
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->diasemana);
                                    if ($superpuesto[0]){
                                        ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else
                                        $salida = $dc->docente0->apellido.', '.substr($dc->docente0->nombre,1,1);
                                    break 1;
                                }else{
                                    $salida = '';
                                }
                            }
                           //return $salida;
            if($vista == 'docentes')
                $arrayaux[$horariox->catedra0->division][$horariox->hora] = $salida;
            else
                $arrayaux[$horariox->catedra0->division][$horariox->hora] = $horariox->catedra0->actividad0->nombre;
        }

        $provider = new ArrayDataProvider([
            'allModels' => $arrayaux,
            'pagination' => false,
            
        ]);
        //return var_dump($array);

        //$docente_materia_search = new DetallecatedraSearch();
       // $dataProvider = $docente_materia_search->horario_doce_divi($division);

        return $this->render('completoxdia', [
            //'model' => $model,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'paramdia' => $paramdia,
            'vista' => $vista,
        ]);
    }

    public function actionCompletoxdocente($docente)
    {
    	//$division = 1;
    	//$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
    	$searchModel = new HorarioSearch();
        $docenteparam = Docente::findOne($docente);

        $h= [];
        $j= [];
        
            $h[1] = '7:15 a 7:55';
            $h[2] = '8:00 a 8:40';
            $h[3] = '8:45 a 9:25';
            $h[4] = '9:30 a 10:10';
            $h[5] = '10:20 a 11:00';
            $h[6] = '11:05 a 11:45';
            $h[7] = '11:50 a 12:30';
            $h[8] = '12:35 a 13:15';
        
            $j[1] = '13:30 a 14:10';
            $j[2] = '14:15 a 14:55';
            $j[3] = '15:00 a 15:40';
            $j[4] = '15:45 a 16:25';
            $j[5] = '16:35 a 17:15';
            $j[6] = '17:20 a 18:00';
            $j[7] = '18:05 a 18:45';
            $j[8] = '18:50 a 19:30';
        
                
        $horariosTm = Horario::find()
        	->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
        	//->where(['diasemana' => 2])
        	->where(['detallecatedra.docente' => $docente])
        	->andWhere(['division.turno' => 1])
        	->andWhere(['detallecatedra.revista' => 6])
        	->andWhere(['tipo' => 1])
        	->orderBy('diasemana, hora')
        	->all();

        $horariosTt = Horario::find()
        	->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
        	//->where(['diasemana' => 2])
        	->where(['detallecatedra.docente' => $docente])
        	->andWhere(['division.turno' => 2])
        	->andWhere(['detallecatedra.revista' => 6])
        	->andWhere(['tipo' => 1])
        	->orderBy('diasemana, hora')
        	->all();

        $dias = Diasemana::find()->where(['not in', 'id',[1,7] ])->all();
        $horas = Hora::find()->all();
        $cd = 0;
        //return var_dump($dias);
        $arrayTm = [];
        $salida = '';
        foreach ($dias as $dia) {
			$ch = 0;
        	foreach ($horas as $hora) {
        		# code...
                if($cd == 0)
                    $arrayTm[$hora->id][$cd] = $h[$ch+1]; 
        		$arrayTm[$hora->id][$dia->id] = '';
        		//$key = arrayTm_search($hora->id, arrayTm_column($horarios, 'hora'));
        		//$salida .= $key;
        		/*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

        		
        		}*/
        		$ch = $ch + 1;
        	}
        	$cd = $cd + 1;
        }
        $salida = '';
        foreach ($horariosTm as $horarioxTm) {
                
                if($arrayTm[$horarioxTm->hora][$horarioxTm->diasemana] != '')
                    $arrayTm[$horarioxTm->hora][$horarioxTm->diasemana] .= ' - ';
        		$arrayTm[$horarioxTm->hora][$horarioxTm->diasemana] .= $horarioxTm->catedra0->division0->nombre;
        }

        $providerTm = new ArrayDataProvider([
	        'allModels' => $arrayTm,
	        
	    ]);
		
		$arrayTt = [];
        $salida = '';
        $cd = 0;
        foreach ($dias as $dia) {
			$ch = 0;
        	foreach ($horas as $hora) {
        		# code...
                if($cd == 0)
                    $arrayTt[$hora->id][$cd] = $j[$ch+1];
        		$arrayTt[$hora->id][$dia->id] = '';
        		//$key = arrayTt_search($hora->id, arrayTt_column($horarios, 'hora'));
        		//$salida .= $key;
        		/*if ($horario->hora == $hora->id && $horario->diasemana == $dia->id){

        		
        		}*/
        		$ch = $ch + 1;
        	}
        	$cd = $cd + 1;
        }
        $salida = '';
        foreach ($horariosTt as $horarioxTt) {
        	
		                	
		                   //return $salida;
		    /*if($vista == 'docentes')
        		$arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] = $salida;
        	else*/
        		$arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] = $horarioxTt->catedra0->division0->nombre;
        }

        $providerTt = new ArrayDataProvider([
	        'allModels' => $arrayTt,
	        
	    ]);

        return $this->render('completoxdocente', [
            
            'providerTm' => $providerTm,
            'providerTt' => $providerTt,
            'docenteparam' => $docenteparam,
            
        ]);
    }

    public function actionMenuxdocente()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $model = new Docente();
        $docentes = Docente::find()->orderBy('apellido, nombre')->all();
        

        if ($model->load(Yii::$app->request->post())) {
            $id = Yii::$app->request->post()['Docente']['apellido'];
            return $this->redirect(['completoxdocente', 'docente' =>  $id]);
        }

        return $this->render('menuxdocente', [
            'model' => $model,
            'docentes' => $docentes,
            
        ]);
    }

    public function actionMenuxletra()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $model = new Docente();
        $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        //$docentes = Docente::find()->select('id, LEFT(apellido, 1) AS inicial, apellido, nombre')->orderBy('apellido, nombre')->all();
        $echodiv = '';
        foreach ($abecedario as $letra) {
                $echodiv .= '<div class="col-md-1 col-lg-1 col-sm-1 col-lx-1" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horario/menuxdocenteletra&letra='.$letra.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        

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
        $model = new Docente();
        $docentes = Docente::find()
            ->joinWith('detallecatedras')
            ->where(['like', 'apellido', $letra.'%', false])
            ->andWhere(['=', 'detallecatedra.revista', 6])
            ->orderBy('apellido, nombre')->all();
        

        $echodiv = '';
        foreach ($docentes as $doc) {
                $echodiv .= '<div class="col-md-2 col-lg-2 col-sm-2 col-lx-2" style="height: 21vh; width:29vh; vertical-align: middle;">';
                $echodiv .= '<div>';
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horario/completoxdocente&docente='.$doc->id.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
            
        ]);
    }

    /**
     * Finds the Horario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
