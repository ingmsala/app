<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\Actividad;
use app\models\Catedra;
use app\models\Clasevirtual;
use app\models\Declaracionjurada;
use app\models\Detallecatedra;
use app\models\DetallecatedraSearch;
use app\models\Diasemana;
use app\models\Division;
use app\models\Agente;
use app\models\Funciondj;
use app\models\Hora;
use app\models\Horario;
use app\models\HorariocontraturnoSearch;
use app\models\Horariodj;
use app\models\Horarioexamen;
use app\models\HorarioSearch;
use app\models\Nombramiento;
use app\models\Parametros;
use app\models\Preceptoria;
use app\models\Rolexuser;
use app\models\Tipomovilidad;
use app\models\Tipoparte;
use app\models\Turnoexamen;
use app\modules\curriculares\models\Aniolectivo;
use kartik\mpdf\Pdf;
use Symfony\Component\Finder\Glob;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                'only' => ['view', 'create', 'update', 'delete', 'menuxdivision', 'completoxcurso', 'completoxdia', 
                                    'completoxdocente', 'createdesdehorario', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 
                                    'menuxletra', 'panelprincipal', 'updatedesdehorario', 'filtropormateria', 
                                    'horariocompleto', 'menuopciones','migrarhorarioprueba', 'printxcurso', 
                                    'printxdocente', 'deshabilitados', 'cambiarmovilidad', 'completodetallado', 'prueba', 'migrarhorariosiguienteanio', 'declaracionhorario', 'publicar', 'horassuperpuestasdj'],
                'rules' => [
                    [
                        'actions' => ['completoxdia', 'completoxdocente', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'filtropormateria', 'horariocompleto', 'menuopciones'],   
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
                        'actions' => ['completoxcurso', 'printxcurso'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
                                        return true;
                                    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                                        $division = Yii::$app->request->queryParams['division'];
                                        //$pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
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

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
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
                        'actions' => ['index', 'view', 'create', 'update', 'readlog', 'migrarhorarioprueba','prueba', 'migrarhorariosiguienteanio'],   
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
                        'actions' => ['createdesdehorario','updatedesdehorario', 'delete', 'printxdocente', 'deshabilitados', 'cambiarmovilidad', 'completodetallado', 'declaracionhorario', 'publicar'],   
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
                    [
                        'actions' => ['horassuperpuestasdj'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_SECRETARIA])){
                                    return true;
                                }else{
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
                    'cambiarmovilidad' => ['POST'],
                    'publicar' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Horario models.
     * @return mixed
     */
    
    public function actionLogin(){
        $model = new Agente();
        $model->scenario = Agente::SCENARIO_FINDHORARIOLOGIN;

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                
                $agente = Agente::find()
                ->joinWith('detallecatedras')
                ->where(['=', 'detallecatedra.revista', 6])
                ->andWhere(['=', 'agente.legajo', $model->legajo])
                ->one();
            Yii::$app->session->setFlash('danger', "Próximamente se habilitará la consuta de los horarios por medio del usuario UNC");
            //return $this->redirect(['/horario/menuopcionespublic', 'h' => Yii::$app->security->generateRandomString(254), 'agente' => $agente->legajo]);
            }
            
        }
        return $this->render('login', [
            'model' => $model,
            
        ]);
    }

    public function actionMenuopcionespublic()
    {
        $this->layout = 'mainpersonal';
        //return $this->redirect(['horario/panelprincipal']);
        
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        
        return $this->render('menuopcionespublic', [
            'h' => Yii::$app->security->generateRandomString(254),
            'agente' => $agente->legajo,
            

        ]);
    }

    public function actionPdfprevios()
    {
        /*$estadopublicacion = Parametros::findOne(2)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes previos");
            return $this->redirect(Yii::$app->request->referrer);
        }elseif($estadopublicacion == 2){
            try {
                if(!in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes previos");
                return $this->redirect(Yii::$app->request->referrer);
            }
            } catch (\Throwable $th) {
                Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes previos");
                return $this->redirect(Yii::$app->request->referrer);
            }
            
        }//1 ok*/
        
        $this->layout = 'mainpersonal';
        
        return $this->redirect(['/turnoexamen']);
    }

        public function actionMarzo()
    {
        $estadopublicacion = Parametros::findOne(3)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes febrero/marzo");
            return $this->redirect(Yii::$app->request->referrer);
        }elseif($estadopublicacion == 2){
            try {
                if(!in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes febrero/marzo");
                return $this->redirect(Yii::$app->request->referrer);
            }
            } catch (\Throwable $th) {
                Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes febrero/marzo");
                return $this->redirect(Yii::$app->request->referrer);
            }
            
        }//1 ok
         if(isset(Yii::$app->user->identity->role))
                $this->layout = 'mainpersonal';
            else
                $this->layout = 'mainpersonal';
        
        
       
        return $this->render('marzo', [
            
            

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
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            //$pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
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
        
        $echodiv = '';
        foreach ($divisiones as $division) {
        		$echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
        		$echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$division->id.'&vista=docentes" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        $almodel = Aniolectivo::find()->where(['activo' => 1])->one();
        $anio = $almodel->id;
        return $this->render('menuxdivision', [
            'echodiv' => $echodiv,
            'anio' => $anio,
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
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 37vh; vertical-align: middle;">';
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

    public function actionCreatedesdehorario($division, $hora, $diasemana, $tipo, $al)
    {
        $model = new Horario();
        $model->scenario = $model::SCENARIO_CREATEHORARIO;
        $model->hora = $hora;
        $model->diasemana = $diasemana;
        $model->tipo = $tipo;
        $model->aniolectivo = $al;

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
                $model2->tipomovilidad = 1;
                $model2->aniolectivo = $al;
                //return var_dump($model2);
                $valid = $model2->validate();
                if($valid){

                    $model2->save();
                    $monologComponent = Yii::$app->monolog;
                    $logger = $monologComponent->getLogger("horarioclase");
                    $logger->log('info', json_encode([
                        "username" => Yii::$app->user->identity->username,
                        "action" => Yii::$app->controller->action->id,
                        "modelnew" => $model2->getAttributes(),
                        "modelold" => [],
                    ]));
                }else{
                    $tr = false;
                    $model->addError('tipo', 'Ya está asignada la hora');
                    //return \yii\widgets\ActiveForm::validate($model);
                    //Yii::$app->session->setFlash('error','err');
                }
            }

            if($tr)
               return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
        }

        

        $catedras = Catedra::find()->joinWith(['detallecatedras'])->where(['division' => $division])->andWhere(['detallecatedra.aniolectivo' => $al])->all();
        //return var_dump($division);
        $horas = Hora::find()->all();
        $dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        $division = Division::findOne($division);
        return $this->render('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'dias' => $dias,
            'tipos' => $tipos,
            'division' => $division,
            'catedras' => $catedras,
            'al' => $al,
        ]);
    }

    public function actionUpdatedesdehorario($division, $hora, $diasemana, $tipo, $al)
    {
        $model = Horario::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['hora' => $hora])
                    ->andWhere(['diasemana' => $diasemana])
                    ->andWhere(['tipo' => $tipo])
                    ->andWhere(['aniolectivo' => $al])
                    ->one();
        

        if ($model->load(Yii::$app->request->post())) {
           //    $model->catedra = $model->catedra;
           
            if($model->tipomovilidad == 1){
                $monologComponent = Yii::$app->monolog;
                    $logger = $monologComponent->getLogger("horarioclase");
                    $logger->log('warning', json_encode([
                        "username" => Yii::$app->user->identity->username,
                        "action" => Yii::$app->controller->action->id,
                        "modelold" => $model->getOldAttributes(),
                        "modelnew" => $model->getAttributes(),
                    ]));

                $model->save();

                return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
            }else{
                Yii::$app->session->setFlash('danger', "No se puede cambiar un horario que no sea 'Móvil'.");
                return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'al' => $al]);
            }
           

           
        }

        $division = Division::findOne($division);
        $tipomovilidad = Tipomovilidad::find()->all();
        $catedras = Catedra::find()->joinWith(['detallecatedras'])->where(['catedra.division' => $division->id])->andWhere(['detallecatedra.aniolectivo' => $al])->all();
        //return var_dump($catedras[9]->detallecatedras);
        $horas = Hora::find()->all();
        $dias = Diasemana::find()->all();
        $tipos = Tipoparte::find()->all();
        return $this->render('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'dias' => $dias,
            'tipos' => $tipos,
            'catedras' => $catedras,
            'tipomovilidad' => $tipomovilidad,
            'al' => $al,
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

    public function actionCambiarmovilidad($id)
    {
        $model = $this->findModel($id);

        
        if($model->tipomovilidad == 1)
            $model->tipomovilidad = 2;
        else
            $model->tipomovilidad = 1;
        $model->save();
        Yii::$app->session->setFlash('success', "Se cambió correctamente el estado de movilidad de la hora");
        return $this->redirect(Yii::$app->request->referrer);
        

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
        $horario = $this->findModel($id);
        if($horario->tipomovilidad == 1){
            $division = $horario->catedra0->division;

            $monologComponent = Yii::$app->monolog;
            $logger = $monologComponent->getLogger("horarioclase");
            $logger->log('error', json_encode([
                "username" => Yii::$app->user->identity->username,
                "action" => Yii::$app->controller->action->id,
                "modelnew" => $horario->getAttributes(),
                "modelold" => [],
            ]));

            $horario->delete();

            return $this->redirect(['/horario/completoxcurso', 'division' => $division, 'vista' => 'docentes']);
        }else{
            Yii::$app->session->setFlash('danger', "No se puede eliminar un horario que no sea 'Móvil'.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        

        
    }

    public function generarHorarioxCurso($division, $vista, $pr, $al){
        $estadopublicacion = Parametros::findOne(1)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de clases");
            return $this->redirect(Yii::$app->request->referrer);
        }

        
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR)
        $this->layout = 'mainpersonal';
        $searchModel = new HorarioSearch();
        $paramdivision = Division::findOne($division);

        $preceptor = Nombramiento::find()
                        ->where(['division' => $paramdivision->id])
                        ->one();
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
            ->andWhere(['aniolectivo' => $al])
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
                if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                  $array[$hora->id][$dia->id] = '<a class="btn btn-info btn-sm" href="?r=horario/createdesdehorario&division='.$division.'&hora='.$hora->id.'&diasemana='.$dia->id.'&tipo=1&al='.$al.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
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
                                if ($dc->revista == 6 && $dc->aniolectivo == $al){
                                    //return var_dump($dc['revista']==1);
                                    
                                    
                                    
                                    #INICIO Bloquear dj
                                    
                                    //$superpuestodj[0] = false;

                                    #FIN Bloquear dj
                                   
                                    if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                                        $superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->diasemana, $dc->aniolectivo);
                                        $superpuestodj = $this->horaSuperpuestaDeclaracionJurada($dc, $horariox->hora, $horariox->diasemana, $dc->aniolectivo, $h);
                                        if ($superpuesto[0] && $superpuestodj[0]){
                                            ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                            $salida = '<span style="color:#f39c12">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].$superpuestodj[1].'">'.$dc->agente0->apellido.', '.substr(ltrim($dc->agente0->nombre),0,1).'</span>'.'</span>';
                                        }
                                        elseif ($superpuesto[0]){
                                            ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                            $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->agente0->apellido.', '.substr(ltrim($dc->agente0->nombre),0,1).'</span>'.'</span>';
                                        }

                                        elseif($superpuestodj[0]){
                                            ($horariox->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                            $salida = '<span style="color:#10D300">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuestodj[1].'">'.$dc->agente0->apellido.', '.substr(ltrim($dc->agente0->nombre),0,1).'</span>'.'</span>';

                                        }
                                        else
                                            $salida = $dc->agente0->apellido.', '.substr(ltrim($dc->agente0->nombre),0,1);
                                        break 1;
                                    }else{
                                        $salida = $dc->agente0->apellido.', '.substr(ltrim($dc->agente0->nombre),0,1);
                                        break 1;
                                    }
                                }else{
                                    $salida = 'ss';
                                }
                            }
                           //return $salida;
            if($vista == 'docentes'){
                if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                    if($pr == 0){
                        if($horariox->tipomovilidad==1)
                            $array[$horariox->hora][$horariox->diasemana] = '<a class="btn btn-link btn-sm" href="?r=horario/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&diasemana='.$horariox->diasemana.'&tipo=1&al='.$al.'">'.$salida.'</a>';
                        else
                            $array[$horariox->hora][$horariox->diasemana] = '<span class="bordermov"><a class="btn btn-link btn-sm" href="?r=horario/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&diasemana='.$horariox->diasemana.'&tipo=1&al='.$al.'">'.$salida.'</a></span>';
                    }
                    else
                        $array[$horariox->hora][$horariox->diasemana] = $salida;
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
        $dataProvider = $docente_materia_search->horario_doce_divi($division, $al);

        
        $model = new Horario();
        $model->aniolectivo = $al;
        $alx = Aniolectivo::findOne($al);
        $alx2 = Aniolectivo::find()->where(['activo' => 1])->one();
        //$anioslectivos = Aniolectivo::find()->limit(2)->orderBy('id DESC')->all();
        $anioslectivos = Aniolectivo::find()->where(['>=', 'id', $alx2->id])->all();
        if(($alx->nombre <> $alx2->nombre) && $pr<>1){
            $colorheader = ['style' => 'background-color:#f2dede'];
            $otro = 1;
        }else{
            $colorheader = [];
            $otro = 0;
        }

        if ($model->load(Yii::$app->request->post())) {
            //return var_dump($model->aniolectivo);
            $session = Yii::$app->session;
		    $session->set('aniolectivosession', $model->aniolectivo);
            return $this->redirect(['completoxcurso', 'division' => $division, 'vista' => $vista, 'al' => $model->aniolectivo]);
            
        }
        $publicado = Parametros::findOne(1);
        if($alx->id == $publicado->estado){
            $publi = 'Publicado';
        }else{
            $publi = Html::a('Publicar', Url::to(['publicar', 'division' => $division, 'vista' => $vista, 'al' => $alx->id]), [
                'class' => 'btn btn-link',
                'data' => [
                    'confirm' => 'Está seguro que desea publicar el horario '.$alx->nombre.'?',
                    'method' => 'post',
                ],
                ]);
        }

        $contraturnoSearch = new HorariocontraturnoSearch();
        $contraturnoProvider = $contraturnoSearch->porDivision($paramdivision->id, $alx->id);

        

        if($pr<>1){
            return $this->render('completoxcurso', [
                //'model' => $model,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                //'dataProviderMartes' => $dataProviderMartes,
                'provider' => $provider,
                'paramdivision' => $paramdivision,
                'vista' => $vista,
                'pr' => $pr,
                'preceptor' => $preceptor,
                'anioslectivos' => $anioslectivos,
                'aniolec' => $al,
                'model' => $model,
                'alx' => $alx,
                'colorheader' => $colorheader,
                'otro' => $otro,
                'publi' => $publi,
                'contraturnoProvider' => $contraturnoProvider,
    
            ]);
        }else{
            return $this->renderAjax('completoxcurso', [
                //'model' => $model,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                //'dataProviderMartes' => $dataProviderMartes,
                'provider' => $provider,
                'paramdivision' => $paramdivision,
                'vista' => $vista,
                'pr' => $pr,
                'preceptor' => $preceptor,
                'anioslectivos' => $anioslectivos,
                'aniolec' => $al,
                'model' => $model,
                'alx' => $alx,
                'colorheader' => $colorheader,
                'otro' => $otro,
                'publi' => $publi,
                'contraturnoProvider' => $contraturnoProvider,
    
            ]);
        }

        
    }

    public function actionPublicar($division, $vista, $al){
        $param = Parametros::findOne(1);
        $param->estado = $al;
        $param->save();
        return $this->redirect(['completoxcurso', 'division' => $division, 'vista' => $vista, 'al' => $al]);
    }


    public function actionDeclaracionhorario($dni){

        
        
        $dj = Declaracionjurada::find()
                ->where(['agente' => $dni])
                ->andWhere(['in', 'estadodeclaracion', [2,3]])
                ->max('id');

        $decla = Declaracionjurada::findOne($dj);

        
        $funciones = Funciondj::find()
            ->where(['declaracionjurada' => $dj])
            ->andWhere(['is not','cargo',null])
            ->all();

        
        $horarios = Horariodj::find()
            ->joinWith(['funciondj0', 'funciondj0.declaracionjurada0'])
            //->where(['diasemana' => 2])
            ->andWhere(['funciondj.declaracionjurada' => $dj])
            ->andWhere(['is', 'horariodj.actividadnooficial', null])
            ->orderBy('diasemana, inicio')
            ->all();
        //return var_dump($horarios);

        $dias = Diasemana::find()->all();
        

        $cd2 = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        foreach ($dias as $dia) {
            $ch2 = 0;
            foreach ($funciones as $funcion) {
                # code...
                
                if($cd2 == 0){
                    $array[$funcion->id][-1] = $ch2+4;
                    if($funcion->licencia == 1)
                        $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.'</em>';
                    else
                        $array[$funcion->id][0] = $funcion->cargo.'<br /><em>'.$funcion->reparticion.' - Licencia</em>';
                }
                    
                if ($funcion->licencia == 1){
                    $array[$funcion->id][$dia->id] = '-';
                }else
                    $array[$funcion->id][$dia->id] = "- ";
                
                $ch2 = $ch2 + 1;
            }
            $cd2 = $cd2 + 1;
        }

        

        $salida = '';
        foreach ($horarios as $horariox) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            if($array[$horariox->funciondj][$horariox->diasemana] == '-'){
                $array[$horariox->funciondj][$horariox->diasemana] = '<div class="label label-default">'.Yii::$app->formatter->asDate($horariox->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariox->fin, 'HH:mm').' '.
                '</div><br />';
            }elseif($array[$horariox->funciondj][$horariox->diasemana] == '- '){
                $array[$horariox->funciondj][$horariox->diasemana] = '-';
            }else{
                $array[$horariox->funciondj][$horariox->diasemana] .= '<div class="label label-default">'.Yii::$app->formatter->asDate($horariox->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariox->fin, 'HH:mm').' '.
            '</div><br />';
            }
           
        }
        
        //$ch2 = count($funciones);


        

        //return var_dump($array);
        
        $provider2 = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);

        return $this->renderAjax('declaracionhorario', [
            
            'provider2' => $provider2,
            
            'decla' => $decla,
            
        ]);


    }

   
    public function actionCompletoxcurso($division, $vista, $al=0)
    {
        $estadopublicacion = Parametros::findOne(1)->estado;
        $almodel = Aniolectivo::find()->where(['id' => $estadopublicacion])->one();

        $anio = $almodel->id;
        
        if($al==0){
            $al = isset($_SESSION['aniolectivosession']) ? $_SESSION['aniolectivosession'] : $anio;
            
        }
        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
            $anio = $al;
        }
    	return $this->generarHorarioxCurso($division, $vista, 0, $anio);
        
    }

    public function actionPrintxcurso($division, $vista, $all = 0, $al)
    {
        
        if(in_array(Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR]))
            $this->layout = 'mainpersonal';
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
                $salidaimpar .=  $this->generarHorarioxCurso($divi->id, $vista, 1, $al);
            
            }
            $filenamesext = "Horario Completo de Clases";
            $filename = $filenamesext.".pdf";
        }else{
            $di = Division::findOne($division);
            $salidaimpar = $this->generarHorarioxCurso($division, $vista, 1, $al);
            $filenamesext = "Horario de Clases - {$di->nombre}";
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
        'marginTop' => 25,
        'defaultFontSize' => '7pt',
        // portrait orientation
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
                
                .body{
                    font-size = 7pt;
                }
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

                img{
                    width: 200px;
                }

                h1{
                    font-size:x-large;
                }
                ', 
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

    public function horaSuperpuesta($dc, $hora, $diasemana, $al){
        $agente = $dc->agente;
        $horarios = Horario::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
            ->where(['detallecatedra.agente' => $agente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'detallecatedra.id', $dc->id])
            ->andWhere(['horario.hora' => $hora])
            ->andWhere(['horario.diasemana' => $diasemana])
            ->andWhere(['horario.tipo' => 1])
            ->andWhere(['detallecatedra.aniolectivo' => $al])
            ->andWhere(['horario.aniolectivo' => $al])  
            ->andWhere(['division.turno' => $dc->catedra0->division0->turno])
            ->all();
        if (count($horarios)>0){
            $salida = '<ul>';
            foreach ($horarios as $sup) {
                $salida .= '<li>Horario: '.$sup->catedra0->division0->nombre.'</li>';
            }
            $salida .= '</ul>';
            return [true, $salida];
        }
            
        else
            return [false, ''];
    }

    

    private function horaSuperpuestaDeclaracionJurada($dc, $hora, $diasemana, $al, $h){
        $agente = $dc->agente0;
        
        $dj = Declaracionjurada::find()
                ->where(['agente' => $agente->documento])
                ->andWhere(['in', 'estadodeclaracion', [2,3]])
                ->max('id');
        //$ff = [];
        foreach ($h as $key => $hx ) {
            $ff[] = explode(' a ',$hx);
        }
        
        


        $horariosdj = null;

        if($dj!=null){
        
            $horariosdj = Horariodj::find()->joinWith(['funciondj0'])
                            ->where(['funciondj.declaracionjurada' => $dj])
                            ->andWhere(['funciondj.licencia' => 1])
                            ->andWhere(['not like', 'funciondj.reparticion', '%monse%', false])
                            ->andWhere(['or',['and',
                                        
                                        ['=', 'horariodj.diasemana', $diasemana],
                                        ['<', 'horariodj.inicio', $ff[$hora-2][0]],
                                        ['>', 'horariodj.fin', $ff[$hora-2][0]],
                                
                                     ], 
                                     ['and',

                                        ['=', 'horariodj.diasemana', $diasemana],
                                        ['<', 'horariodj.inicio', $ff[$hora-2][1]],
                                        ['>', 'horariodj.fin', $ff[$hora-2][1]],
                                
                                     ],     
                            
                            ])
                            
                            ->all();
            
        }
        
        
        //return $horariosdj;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        if ($horariosdj!=null){
            $salida = '<ul>';
            foreach ($horariosdj as $horariodjx) {
                $salida .= '<li>Dec. Jurada: '.$horariodjx->funciondj0->reparticion .' - '.$horariodjx->funciondj0->cargo.' ('.Yii::$app->formatter->asDate($horariodjx->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($horariodjx->fin, 'HH:mm').')</li>';
            }
            $salida .= '</ul>';
            return [true, $salida, $dj];
        }
            
        else
            return [false, '', $dj];

        
        





    }


    public function actionCompletoxdia($dia, $vista)
    {
        //$division = 1;
        //$dia = 3;
        
        $estadopublicacion = Parametros::findOne(1)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes clases");
            return $this->redirect(Yii::$app->request->referrer);
        }

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioSearch();
        $paramdia = Diasemana::findOne($dia);
        
        
        $horarios = Horario::find()
            ->joinWith(['catedra0'])
            ->where(['diasemana' => $dia])
            ->andWhere(['<>','catedra.division',77])
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
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else
                                        $salida = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);
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

    public function actionHorarioclasespublic()
    {
        $estadopublicacion = Parametros::findOne(1)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de clases");
            return $this->redirect(Yii::$app->request->referrer);
        }

        $this->layout = 'mainpersonal';
        /*$agente = Agente::find()
                ->joinWith('detallecatedras')
                ->where(['=', 'detallecatedra.revista', 6])
                ->andWhere(['=', 'agente.legajo', $agente])
                ->one();*/
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            return $this->redirect(['menuxdivision']);
        }
        $agente = Agente::find()->joinWith('detallecatedras')
                    ->where(['mail' => Yii::$app->user->identity->username])
                    ->andWhere(['=', 'detallecatedra.revista', 6])
                    ->one();
        if($agente == null){
            Yii::$app->session->setFlash('info', "No tiene horarios de clases asignados en su perfil de ".Yii::$app->user->identity->role0->nombre.'. Si desea acceder a los horarios como Preceptor/a o Jefe/a de Preceptor/a deberá cambiar su perfil de usuarios desde el menú.');
            return $this->redirect(['menuopcionespublic']);
        }
        
        $alx2 = Aniolectivo::find()->where(['id' => $estadopublicacion])->one();
        return $this->getCompletoxdocentepage($agente->id, 0, 0, 1, $alx2->id);
    }

    public function actionCompletoxdocente($agente, $al=0)
    {
        $estadopublicacion = Parametros::findOne(1)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de exámenes clases");
            return $this->redirect(Yii::$app->request->referrer);
        }


        $almodel = Aniolectivo::find()->where(['id' => $estadopublicacion])->one();
        $anio = $almodel->id;
        
        if($al==0){
            $al = isset($_SESSION['aniolectivosession']) ? $_SESSION['aniolectivosession'] : $anio;
            
        }
        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
            $anio = $al;
        }
    	

        return $this->getCompletoxdocentepage($agente, 0, 0, 0, $anio);
    }

    public function actionPrintxdocente($agente, $all=0, $al)
    {
        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        if(in_array(Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR]))
            $this->layout = 'mainpersonal';
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        $salidaimpar = '';
        
        if($all){
            ini_set("pcre.backtrack_limit", "5000000");
            
             $docentes = Agente::find()
                            ->joinWith(['detallecatedras'])
                            ->where(['=', 'detallecatedra.revista', 6])
                            ->orderBy('agente.apellido, agente.nombre')
                            ->all();
            

            
            foreach ($docentes as $doce) {
                $salidaimpar .=  $this->getCompletoxdocentepage($doce->id, 1, 1, 0, $al);
            
            }
            $filenamesext = "Horario de Clases por Agente Completo ";
            $filename = $filenamesext.".pdf";
        }else{
            $agente = Agente::findOne($agente);
            $salidaimpar = $this->getCompletoxdocentepage($agente->id, 1, 0, 0, $al);
            $filenamesext = "Horario de Clases - {$agente->apellido}, {$agente->nombre}";
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
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
                
                .horario-view{
                    font-size = 8px;
                }
                .col-md-6 {
                        width: 45%;
                        float: left;
                        
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
    //return $salidaimpar;
    return $pdf->render();
        
    }

    public function getCompletoxdocentepage($agente, $pr = 0, $all = 0, $horario = 0, $al)
    {
    	//$division = 1;
    	//$dia = 3;
        $userhorario = false;
        if($horario == 0){
            if(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                $userhorario = true;
            }
        }else{
            $userhorario = true;
        }
    	$searchModel = new HorarioSearch();
        $docenteparam = Agente::findOne($agente);

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
        	->where(['detallecatedra.agente' => $agente])
        	->andWhere(['division.turno' => 1])
        	->andWhere(['detallecatedra.revista' => 6])
        	->andWhere(['tipo' => 1])
        	->andWhere(['detallecatedra.aniolectivo' => $al])
        	->andWhere(['horario.aniolectivo' => $al])
        	->orderBy('diasemana, hora')
        	->all();

        $horariosTt = Horario::find()
        	->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0'])
        	//->where(['diasemana' => 2])
        	->where(['detallecatedra.agente' => $agente])
        	->andWhere(['division.turno' => 2])
        	->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['tipo' => 1])
            ->andWhere(['detallecatedra.aniolectivo' => $al])
        	->andWhere(['horario.aniolectivo' => $al])
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
                if($horarioxTm->tipomovilidad == 1)
        		    $arrayTm[$horarioxTm->hora][$horarioxTm->diasemana] .= $horarioxTm->catedra0->division0->nombre;
                else
                    $arrayTm[$horarioxTm->hora][$horarioxTm->diasemana] .= '<span class="bordermov">'.$horarioxTm->catedra0->division0->nombre.'</span>';
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
                if($arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] != '')
                    $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] .= ' - ';
                if($horarioxTt->tipomovilidad == 1)
        		    $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] .= $horarioxTt->catedra0->division0->nombre;
                else
                    $arrayTt[$horarioxTt->hora][$horarioxTt->diasemana] .= '<span class="bordermov">'.$horarioxTt->catedra0->division0->nombre.'</span>';
        }

        $providerTt = new ArrayDataProvider([
	        'allModels' => $arrayTt,
	        
        ]);
        
        $alx = Aniolectivo::findOne($al);
        $alx2 = Aniolectivo::find()->where(['activo' => 1])->one();
        if($alx->nombre <> $alx2->nombre && in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
            $colorheader = ['style' => 'background-color:#f2dede'];
            $otro = 1;
        }else{
            $colorheader = [];
            $otro = 0;
        }

        $model = new Horario();
        $model->aniolectivo = $al;
        $alx = Aniolectivo::findOne($al);
        $alx2 = Aniolectivo::find()->where(['activo' => 1])->one();
        //$anioslectivos = Aniolectivo::find()->limit(2)->orderBy('id DESC')->all();
        $anioslectivos = Aniolectivo::find()->where(['>=', 'id', $alx2->id])->all();
        
        if ($model->load(Yii::$app->request->post())) {
            //return var_dump($model->aniolectivo);
            $session = Yii::$app->session;
		    $session->set('aniolectivosession', $model->aniolectivo);
            return $this->redirect(['completoxdocente', 'agente' => $agente, 'al' => $model->aniolectivo]);
            
        }

        if($pr<>1){

            return $this->render('completoxdocente', [
                'userhorario' => $userhorario,
                'providerTm' => $providerTm,
                'providerTt' => $providerTt,
                'docenteparam' => $docenteparam,
                'pr' => $pr,
                'alx' => $alx,
                'colorheader' => $colorheader,
                'otro' => $otro,
                'anioslectivos' => $anioslectivos,
                'model' => $model,
                
            ]);
        }else{
            return $this->renderAjax('completoxdocente', [
                'userhorario' => $userhorario,
                'providerTm' => $providerTm,
                'providerTt' => $providerTt,
                'docenteparam' => $docenteparam,
                'pr' => $pr,
                'alx' => $alx,
                'colorheader' => $colorheader,
                'otro' => $otro,
                'anioslectivos' => $anioslectivos,
                'model' => $model,
                
            ]);
        }
    }

    public function actionMenuxdocente()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $model = new Agente();
        $docentes = Agente::find()->orderBy('apellido, nombre')->all();
        

        if ($model->load(Yii::$app->request->post())) {
            $id = Yii::$app->request->post()['Agente']['apellido'];
            return $this->redirect(['completoxdocente', 'agente' =>  $id]);
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
        $model = new Agente();
        $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        //$docentes = Agente::find()->select('id, LEFT(apellido, 1) AS inicial, apellido, nombre')->orderBy('apellido, nombre')->all();
        $echodiv = '';
        $echodiv .= '<div class="row">';
        foreach ($abecedario as $letra) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horario/menuxdocenteletra&letra='.$letra.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
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
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horario/completoxdocente&agente='.$doc->id.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
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


    public function actionHoraxdivisionxdocente($diasemana)
    {
        
        $aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];

            $division_id = empty($parents[0]) ? null : $parents[0];
            $docente_id = empty($parents[1]) ? null : $parents[1];
            $falta_id = empty($parents[2]) ? null : $parents[2];

            if ($parents != null &&  $division_id != null && $docente_id != null && $falta_id != null) {

                if($falta_id == 3 || $falta_id == 1){

                    $horario = Horario::find()
                                ->joinWith(['catedra0', 'catedra0.detallecatedras', ])
                                ->where(['catedra.division' => $division_id])
                                ->andWhere(['detallecatedra.revista' => 6])
                                ->andWhere(['detallecatedra.agente' => $docente_id])
                                ->andWhere(['horario.diasemana' => $diasemana])
                                ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo->id])
                                ->andWhere(['horario.aniolectivo' => $aniolectivo->id])
                                ->orderBy('horario.hora')
                                ->all();
                }else{
                    $horario = Horario::find()
                                ->joinWith(['catedra0', 'catedra0.detallecatedras', ])
                                ->where(['catedra.division' => $division_id])
                                ->andWhere(['detallecatedra.revista' => 6])
                                //->andWhere(['detallecatedra.agente' => $docente_id])
                                ->andWhere(['horario.diasemana' => $diasemana])
                                ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo->id])
                                ->andWhere(['horario.aniolectivo' => $aniolectivo->id])
                                ->orderBy('horario.hora')
                                ->all();
                }



                
                
       

                $listhorario=ArrayHelper::toArray($horario, [
                    'app\models\Horario' => [
                        'id' => function($horax) {
                            return $horax['hora0']['id'];},
                        'name' => function($horax) {
                            return $horax['hora0']['nombre'];},
                    ],
                ]);
                $out = $listhorario;
                
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];

        
        
        
    }

    public function actionFiltropormateria()
    {
        //$division = 1;
        //$dia = 3;

        $aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();
        
        $param = Yii::$app->request->queryParams;
        $model = new Actividad();
        $modelCatedra = new Catedra();
        $repetido = false;
        $matexp = '';

        $anios = Aniolectivo::find()->all();

        if(isset($param['Catedra']['aniolectivo'])){
            $modelCatedra->aniolectivo = $param['Catedra']['aniolectivo'];
        }else{
            $modelCatedra->aniolectivo = 0;
        }

        try{
             $largo = count($param['Actividad']['id']);
         }catch(\Exception $exception){
            $largo = 0;
        }

        $materiasfiltro = [];
        if($largo<1){
            $materiasfiltro = isset($param['Actividad']['id']) ? [$param['Actividad']['id']] : [0];
            $model->id = $materiasfiltro;
            
        }else{
            if(isset($param['Actividad']['id']))
                $materiasfiltro = $param['Actividad']['id'];
            $model->id = $materiasfiltro;

            
            $cm = 0;
            foreach ($materiasfiltro as $value) {
                if($cm == 0)
                    $matexp .= ': '.Actividad::findOne($value)->nombre;
                else
                    $matexp .= ' - '.Actividad::findOne($value)->nombre;
                
                $cm++;
            }

            $divi = [];
            
            //$query = "SUBSTRING([[division]].[[nombre]],1) as [[hh]]";
            foreach ($materiasfiltro as $mat) {
                $divi[] = Division::find()
                            ->joinWith('catedras', 'catedras.division0')
                            ->where(['in', 'catedra.actividad', $mat])
                            ->andWhere(['in', 'division.turno', [1,2]])
                            ->orderBy('division.turno, division.id')
                            ->one()->nombre;
                
            }
            $cantmaterias = count($divi);
            $valores = array_count_values($divi);
            //$repetido = false;
            foreach ($valores  as $key => $value) {
                if ($value > 1){
                    $repetido = true;
                }
            }
            
            //return var_dump($valores);
        }

        if($repetido && $cantmaterias>1){
            Yii::$app->session->setFlash('info', "Está seleccionando más de una materia de un año de cursada.");
            $rep = true;
                
                //$materiasfiltro = [0];
        }else{
            $rep = false;
        }

        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioSearch();
        //$paramdia = Diasemana::findOne($dia);
        
        
        $horarios = Horario::find()
            ->joinWith(['catedra0'])
            ->where(['in', 'catedra.actividad', $materiasfiltro])
            ->andWhere(['<>', 'catedra.division', 77])
            ->andWhere(['tipo' => 1])
            ->andWhere(['aniolectivo' => $modelCatedra->aniolectivo])
            ->orderBy('diasemana, hora')
            ->all();

        $divisiones = Division::find()
                        ->distinct()
                        ->joinWith('catedras', 'catedras.division0')
                        ->where(['in', 'catedra.actividad', $materiasfiltro])
                        ->andWhere(['in', 'division.turno', [1,2]])
                        ->orderBy('division.turno, division.id')
                        ->all();
        $horas = Diasemana::find()->where(['not in', 'id',[1,7]])->all();
        $cd = 0;
        //return var_dump($dias);
        
        $arrayaux = [];

        $salida = '';
        foreach ($divisiones as $division) {
            $ch = 0;
            foreach ($horas as $hora) {

                if($ch == 0){
                    $arrayaux[999][998] = 'MAÑANA';
                    $arrayaux[998][998] = 'TARDE';
                    $arrayaux[999][1] = 'Hora';
                    $arrayaux[998][1] = 'Hora';

                    $arrayaux[$division->id][$ch+1] = $division->nombre;
                }
                if($ch == 1){
                    $arrayaux[$division->id][999] = '';
                    $arrayaux[$division->id][998] = '';
                    $arrayaux[999][999] = 'Libre';
                    $arrayaux[998][999] = 'Libre';

                }

                $ch = $ch + 1;
                

                $arrayaux[$division->id][$hora->id] = '';
                if($hora->id >= 2){
                    $c = 0;
                    foreach (['1°', '2°','3°','4°','5°','6°','7°','8°'] as $conthor) {
                        if ($c == 0){
                            $arrayaux[999][$hora->id] = '<span><div style="font-size:12pt;" class="label label-success pull-left">'.$conthor.'</div></span>';
                            $arrayaux[998][$hora->id] = '<span><div style="font-size:12pt;" class="label label-success pull-left">'.$conthor.'</div></span>';
                        }else{
                            $arrayaux[999][$hora->id] = str_replace('</span>', '<div style="font-size:12pt;" class="label label-success pull-left">'.$conthor.'</div></span>', $arrayaux[999][$hora->id]);
                            $arrayaux[998][$hora->id] = str_replace('</span>', '<div style="font-size:12pt;" class="label label-success pull-left">'.$conthor.'</div></span>', $arrayaux[998][$hora->id]);
                        }
                        $c = $c + 1;
                        /*$arrayaux[998][$hora->id] = '<span><div style="font-size:12pt;" class="label label-success pull-left">'.$conthor.'</div></span>';*/
                    }
                }
                    
                

                                
            }
            
        }
        //return var_dump($arrayaux);
        $salida = '';
        foreach ($horarios as $horariox) {
            
                            foreach ($horariox->catedra0->detallecatedras as $dc) {

                                $salida = '';
                                if ($dc->revista == 6 && $dc->aniolectivo == $modelCatedra->aniolectivo){
                                    //return var_dump($dc['revista']==1);
                                    //$superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->diasemana);
                                    //if ($superpuesto[0]){
                                        $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                                        $turno = $dc->catedra0->division0->turno0->nombre;
                                        $salida = $horariox->hora0->nombre;
                                    break 1;
                                }else{
                                    $salida = '';
                                }
                            }
                           //return $salida;
            
                if( in_array($horariox->catedra0->actividad0->id,$materiasfiltro)){
                    if($arrayaux[$horariox->catedra0->division][$horariox->diasemana] == ''){
                        $arrayaux[$horariox->catedra0->division][999] = $doc;
                        $arrayaux[$horariox->catedra0->division][998] = $turno;
                        $va = true;

                        if($turno == "MAÑANA"){
                            $divit = 999;
                        }elseif($turno == "TARDE"){
                            $divit = 998;
                        
                        }
                        
                        $arrayaux[$divit][$horariox->diasemana] = str_replace('<div style="font-size:12pt;" class="label label-success pull-left">'.$salida.'</div>', '', $arrayaux[$divit][$horariox->diasemana]);

                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = '<span><div style="font-size:12pt;" class="label label-danger pull-left">'.$salida.'</div></span>';
                    }else{
                        $va = false;

                        if($turno == "MAÑANA"){
                            $divit = 999;
                        }elseif($turno == "TARDE"){
                            $divit = 998;
                        
                        }
                        
                        $arrayaux[$divit][$horariox->diasemana] = str_replace('<div style="font-size:12pt;" class="label label-success pull-left">'.$salida.'</div>', '', $arrayaux[$divit][$horariox->diasemana]);

                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = str_replace('</span>', '<div style="font-size:12pt;" class="label label-danger pull-left">'.$salida.'</div></span>', $arrayaux[$horariox->catedra0->division][$horariox->diasemana]);
                    }
                        
                        
                    /*if($va){
                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = '</ul>';
                    }*/
                }
            
        }

        $provider = new ArrayDataProvider([
            'allModels' => $arrayaux,
            'pagination' => false,
            
        ]);
        //return var_dump($array);

        //$docente_materia_search = new DetallecatedraSearch();
       // $dataProvider = $docente_materia_search->horario_doce_divi($division);

        $actividades = Actividad::find()
                        ->joinWith(['catedras', 'catedras.division0'])
                        ->where(['<>', 'actividad.id', 23])
                        ->andWhere(['in', 'division.turno',[1,2]])
                        ->orderBy('actividad.nombre')
                        ->all();

        return $this->render('filtropormateria', [
            'model' => $model,
            'modelCatedra' => $modelCatedra,
            'anios' => $anios,
            'actividades' => $actividades,
            'rep' => $rep,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'matexp' => $matexp,
            
        ]);
    }

    public function actionHorariocompleto($al=0)
    {

        $almodel = Aniolectivo::find()->where(['activo' => 1])->one();
        $anio = $almodel->id;
        
        if($al==0){
            $al = isset($_SESSION['aniolectivosession']) ? $_SESSION['aniolectivosession'] : $anio;
            
        }
        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
            $anio = $al;
        }
        
        $model = new Actividad();
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        $searchModel = new HorarioSearch();
        //$paramdia = Diasemana::findOne($dia);
        
        
        $horarios = Horario::find()
            ->joinWith(['catedra0'])
            ->andWhere(['<>', 'catedra.division', 77])
            ->andWhere(['tipo' => 1])
            ->andWhere(['aniolectivo' => $anio])
            ->orderBy('diasemana, hora')
            ->all();

        $divisiones = Division::find()
                        ->distinct()
                        ->joinWith('catedras', 'catedras.division0')
                        ->where(['in', 'division.turno', [1,2]])
                        ->orderBy('division.turno, division.id')
                        ->all();
        $horas = Diasemana::find()->where(['not in', 'id',[1,7]])->all();
        $cd = 0;
        //return var_dump($dias);
        
        $arrayaux = [];

        $salida = '';
        foreach ($divisiones as $division) {
            $ch = 0;
            foreach ($horas as $hora) {

                if($ch == 0){
                    $arrayaux[$division->id][$ch+1] = $division->nombre;
                }
                if($ch == 1){
                    $arrayaux[$division->id][999] = '';
                    $arrayaux[$division->id][998] = '';

                    $dc = Detallecatedra::find()
                        ->joinWith(['catedra0', 'catedra0.actividad0'])
                        ->where(['catedra.division' => $division->id])
                        ->andWhere(['revista' => 6])
                        ->andWhere(['aniolectivo' => $anio])
                        ->orderBy('actividad.nombre')->all();
                    $docymat = '';
                    $c2 = 0;
                    foreach ($dc as $d) {
                        if($c2 == 0)
                            $arrayaux[$division->id][999] = '<ol><li><span class="label label-info">'.$d->catedra0->actividad0->nombre.': </span><span class="label" style="color:black;">'.$d->agente0->apellido.', '.$d->agente0->nombre.'</li></ol>';
                        else{
                            $arrayaux[$division->id][999] = str_replace('</ol>', '<li><span class="label label-info">'.$d->catedra0->actividad0->nombre.': </span><span class="label" style="color:black;">'.$d->agente0->apellido.', '.$d->agente0->nombre.'</li></ol>', $arrayaux[$division->id][999]);
                        }
                        $c2++;
                    }

                   // $arrayaux[$division->id][999] = $docymat;
                }

                $ch = $ch + 1;
                

                $arrayaux[$division->id][$hora->id] = '';
                
                    
                

                                
            }
            
        }
        //return var_dump($arrayaux);
        $salida = '';
        foreach ($horarios as $horariox) {
            
                            foreach ($horariox->catedra0->detallecatedras as $dc) {

                                $salida = '';
                                if ($dc->revista == 6){
                                    //return var_dump($dc['revista']==1);
                                    //$superpuesto = $this->horaSuperpuesta($dc, $horariox->hora, $horariox->diasemana);
                                    //if ($superpuesto[0]){
                                        $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                                        $turno = $dc->catedra0->division0->turno0->nombre;
                                        $salida = $horariox->hora0->nombre.' - '.$doc;
                                    break 1;
                                }else{
                                    $salida = '';
                                }
                            }
                           //return $salida;
            
                //if( in_array($horariox->catedra0->actividad0->id,$materiasfiltro)){
                    if($arrayaux[$horariox->catedra0->division][$horariox->diasemana] == ''){
                        //$arrayaux[$horariox->catedra0->division][999] = $doc;
                        //$arrayaux[$horariox->catedra0->division][998] = $turno;
                        $va = true;
                        $arrayaux[$horariox->catedra0->division][998] = $turno;
                         
                        
                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = '<span><div style="font-size:12pt;" class="label label-default pull-left">'.$salida.'</div></span>';
                    }else{
                        $va = false;

                        
                        $arrayaux[$horariox->catedra0->division][998] = $turno;
                         

                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = str_replace('</span>', '<div style="font-size:12pt;" class="label label-default pull-left">'.$salida.'</div></span>', $arrayaux[$horariox->catedra0->division][$horariox->diasemana]);
                    }
                        
                        
                    /*if($va){
                        $arrayaux[$horariox->catedra0->division][$horariox->diasemana] = '</ul>';
                    }*/
                //}
            
        }

        $provider = new ArrayDataProvider([
            'allModels' => $arrayaux,
            'pagination' => false,
            
        ]);
        //return var_dump($array);

        //$docente_materia_search = new DetallecatedraSearch();
       // $dataProvider = $docente_materia_search->horario_doce_divi($division);

        $actividades = Actividad::find()
                        ->joinWith(['catedras', 'catedras.division0'])
                        ->where(['<>', 'actividad.id', 23])
                        ->andWhere(['in', 'division.turno',[1,2]])
                        ->orderBy('actividad.nombre')
                        ->all();

        

        $anioslectivos = Aniolectivo::find()->limit(2)->orderBy('id DESC')->all();
        $model2 = new Horario();
        $model2->aniolectivo = $anio;
        $aniolec = Aniolectivo::findOne($anio);
        if ($model2->load(Yii::$app->request->post())) {
            //return var_dump($model->aniolectivo);
            $session = Yii::$app->session;
		    $session->set('aniolectivosession', $model2->aniolectivo);
            return $this->redirect(['horariocompleto', 'al' => $model2->aniolectivo]);
            
        }

        return $this->render('horariocompleto', [
            'model' => $model,
            'actividades' => $actividades,
            //'rep' => $rep,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //'dataProviderMartes' => $dataProviderMartes,
            'provider' => $provider,
            'anioslectivos' => $anioslectivos,
            'model2' => $model2,
            'aniolec' => $aniolec,
            
        ]);
    }

    public function actionMenuopciones()
    {
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
        //return $this->redirect(['horario/panelprincipal']);
        return $this->render('menuopciones');
    }

    public function actionReadlog($tipo)
    {
        if($tipo == 1){
            $path = Url::to("@app/runtime/logs/")."horarioclase.log";
            $title = "Horario a clases";
        }
        elseif($tipo == 2){
            $path = Url::to("@app/runtime/logs/")."horarioexamen.log";
            $title = "Horario a trimestrales";
        }
        elseif($tipo == 3){
            $path = Url::to("@app/runtime/logs/")."horariocoloquio.log";
            $title = "Horario a coloquios";
        }
        $file = new \SplFileObject($path);
        $out = [];
        while (!$file->eof()) {
            $out[]= explode (" ", $file->fgets());
            //$out[]=$file->fgets();
            //$line = explode("\t", $line);
          
        }
        $out2 = [];
        foreach ($out as $line) {
            if(isset($line[1])){
                $line[0] = substr($line[0],1);
                $line[1] = substr($line[1],0,8);
                if($line[2] == 'horarioclase.INFO:')
                    $line[2] = "Alta";
                elseif($line[2] == 'horarioclase.WARNING:')
                    $line[2] = "Actualización";
                else
                    $line[2] = "Borrado";
                $line[3] = json_decode( $line[3]);
                unset($line[4]);
                unset($line[5]);
                $out2[] = $line;
            }
            
            
        }

        

        $filteredresultData = array_filter($out2, function ($item) {
            $mailfilter = Yii::$app->request->getQueryParam('filteremail', '');
            $materiafilter = Yii::$app->request->getQueryParam('filtermateria', '');
            if (strlen($mailfilter) > 0 || strlen($materiafilter) > 0) {
                $materiafilter = strtoupper($materiafilter);

                $cat = Catedra::findOne($item['3']->modelnew->catedra);

                foreach ($cat->detallecatedras as $dc) {
                    if ($dc->revista == 6){
                        $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                        break;
                    }
                }
                $div = strlen($mailfilter) > 0 ? strpos(Catedra::findOne($item['3']->modelnew->catedra)->division0->nombre, $mailfilter) : true;
                $mat = false;
                if (strlen($materiafilter) > 0)

                   if(strpos($doc,$materiafilter) !== false){
                        $mat = true;
                   }else{
                        $mat = strpos(Catedra::findOne($item['3']->modelnew->catedra)->actividad0->nombre, $materiafilter);
                   }
                else
                    $mat = true;

                if ($div !== false && $mat !== false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        });


        $mailfilter = Yii::$app->request->getQueryParam('filteremail', '');
        $materiafilter = Yii::$app->request->getQueryParam('filtermateria', '');

        $searchModel = ['ee' => $mailfilter, 'materia' => $materiafilter];

        $dataProvider = new ArrayDataProvider([
            'allModels' => array_reverse($filteredresultData),
            'pagination' => false,
            'sort' => [
                'attributes' => ['0', '1'],
            ]
            
        ]);
        return $this->render('readlog', [
            'dataProvider' => $dataProvider,
            'title' => $title,
            'searchModel' => $searchModel,
            'divisiones' => Division::find()->all(),
            
        ]);
        

    }

    public function actionMigrarhorarioprueba($aniolectivo)
    {
        $horariosactuales = Horario::find()->where(['aniolectivo' => $aniolectivo])->all();
        $c = 0;
        foreach ($horariosactuales as $horario) {
            $nuevohorario = new Horario();
            $nuevohorario = $horario;
            $nuevohorario->aniolectivo = $horario->aniolectivo+1;
            //$nuevohorario->save();
            $c++;
        }
        Yii::$app->session->setFlash('success', "Se realizó la migración de {$c} horarios.");
        return $this->redirect(['/horario/panelprincipal']);
    }

    public function actionHorassuperpuestas(){

            $anios = Aniolectivo::find()->all();
            $model = new Catedra();

            if (Yii::$app->request->post()) {
                $searchModel = new HorarioSearch;
                $dataProvider = $searchModel->horassuperpuestas(Yii::$app->request->post()['Catedra']['aniolectivo']);
	        }else{
                $searchModel = new HorarioSearch();
	            $dataProvider = $searchModel->horassuperpuestas(0);
            }

            if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
                $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
            }

        return $this->render('horassuperpuestas', [
            'model' => $model,
            'anios' => $anios,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            
            
        ]);
    }

    public function actionHorassuperpuestasdj(){

        if (Yii::$app->request->post()) {
            $al = Yii::$app->request->post()['Catedra']['aniolectivo'];
            $alx = Aniolectivo::findOne($al);
            $alx = ' - '.$alx->nombre;
            $superpuestas = [];
            $horarios = Horario::find()
                            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.detallecatedras.agente0'])
                            //->where(['diasemana' => 2])
                            ->andWhere(['tipo' => 1])
                            //->andWhere(['horario.aniolectivo' => $al])
                            ->andWhere(['horario.aniolectivo' => $al])
                            ->orderBy('agente.apellido, agente.nombre, diasemana, hora')
                            ->all();

                            //return var_dump($horarios);

            foreach ($horarios as $horariox) {

                $turno = $horariox->catedra0->division0->turno;
                $h= [];
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
                    $h[1] = '13:30 a 14:10';
                    $h[2] = '14:15 a 14:55';
                    $h[3] = '15:00 a 15:40';
                    $h[4] = '15:45 a 16:25';
                    $h[5] = '16:35 a 17:15';
                    $h[6] = '17:20 a 18:00';
                    $h[7] = '18:05 a 18:45';
                    $h[8] = '18:50 a 19:30';
                }

                foreach ($horariox->catedra0->detallecatedras as $dc) {

                    $salida = '';
                    if ($dc->revista == 6 && $dc->aniolectivo == $al){
                    
                        try {
                            $superpuestodj = $this->horaSuperpuestaDeclaracionJurada($dc, $horariox->hora, $horariox->diasemana, $dc->aniolectivo, $h);
                            if($superpuestodj[0]){
                                $superpuestas[$dc->id]['division']=$dc->catedra0->division0->nombre;
                                $superpuestas[$dc->id]['actividad']=$dc->catedra0->actividad0->nombre;
                                $superpuestas[$dc->id]['agente']=$dc->agente0->apellido.', '.$dc->agente0->nombre;
                                $superpuestas[$dc->id]['hora']=$horariox->hora0->nombre.' ('.$h[$horariox->hora-1].')';
                                $superpuestas[$dc->id]['dia']=$horariox->diasemana0->nombre;
                                $superpuestas[$dc->id]['superposicion']=$superpuestodj[1];
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                
                    }   
                
                }

            }
        }else{
            $superpuestas = [];
            $alx = '';
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $superpuestas,
            'pagination' => false,
            
        ]);

        $anios = Aniolectivo::find()->all();
            $model = new Catedra();
        

        if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
            $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
        }
        return $this->render('horassuperpuestasdj', [
            //'model' => $model,
            //'searchModel' => $searchModel,
            'model' => $model,
            'anios' => $anios,
            'dataProvider' => $dataProvider,
            'alx' => $alx,
            

        ]);


                        
        

        
            
            $anios = Aniolectivo::find()->all();
            $model = new Catedra();

            if (Yii::$app->request->post()) {
                $searchModel = new HorarioSearch;
                $dataProvider = $searchModel->horassuperpuestas(Yii::$app->request->post()['Catedra']['aniolectivo']);
	        }else{
                $searchModel = new HorarioSearch();
	            $dataProvider = $searchModel->horassuperpuestas(0);
            }

            if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
                $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
            }

        return $this->render('horassuperpuestas', [
            'model' => $model,
            'anios' => $anios,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            
            
        ]);
    }

    public function actionDeshabilitados()
    {
        $anios = Aniolectivo::find()->all();
        $model = new Catedra();

        if (Yii::$app->request->post()) {
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getDeshabilitados(Yii::$app->request->post()['Catedra']['aniolectivo']);
        }else{
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getDeshabilitados(0);
        }

        if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
            $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
        }

        
        return $this->render('deshabilitados', [
            'model' => $model,
            'anios' => $anios,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCompletodetallado()
    {
        $anios = Aniolectivo::find()->all();
        $model = new Catedra();

        if (Yii::$app->request->post()) {
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getCompletoDetallado(Yii::$app->request->post()['Catedra']['aniolectivo']);
        }else{
            $searchModel = new HorarioSearch();
            $dataProvider = $searchModel->getCompletoDetallado(0);
        }

        if(isset(Yii::$app->request->post()['Catedra']['aniolectivo'])){
            $model->aniolectivo = Yii::$app->request->post()['Catedra']['aniolectivo'];
        }

        return $this->render('completodetallado', [
            'model' => $model,
            'anios' => $anios,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMigrarhorariosiguienteanio($actual,$siguiente)
    {
        $horarios = Horario::find()->where(['aniolectivo' => $actual])->all();
        ini_set("pcre.backtrack_limit", "5000000");
        foreach ($horarios as $horario) {
            $newHorario = new Horario();
            $newHorario->catedra = $horario->catedra;
            $newHorario->hora = $horario->hora;
            $newHorario->diasemana = $horario->diasemana;
            $newHorario->tipo = $horario->tipo;
            $newHorario->tipomovilidad = $horario->tipomovilidad;
            $newHorario->aniolectivo = $siguiente;
            $newHorario->save();
        }
        return $this->redirect(['/horario/panelprincipal']);
    }

      
    public function actionClasesvirtuales()
    {
        /*$searchModel = new HorarioSearch();
        $dataProvider = $searchModel->getDeshabilitados();*/

        $horarioexamen = Clasevirtual::find()->all();
        $events = [];

        $docs = Agente::find()->all();
        foreach ($docs as $doc) {
         /*foreach ($horarioexamen as $horario) {
            $agente = '';
            
           foreach ($horario->catedra0->detallecatedras as $dc) {
                
                if ($dc->revista == 6){
                    $agente = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);
                    break 1;
                }
                
            }

            if($horario->catedra0->division0->turno == 1){
                $color = '#7986cb';
                if($horario->hora == 2){
                    $inicio = '08:00';
                    $fin = '09:00';
                }elseif($horario->hora == 3){
                    $inicio = '09:00';
                    $fin = '10:00';
                }else{
                    $inicio = '10:00';
                    $fin = '11:00';
                }
            }else{
                $color = '#4285f4';
                if($horario->hora == 2){
                    $inicio = '14:00';
                    $fin = '15:00';
                }elseif($horario->hora == 3){
                    $inicio = '15:00';
                    $fin = '16:00';
                }else{
                    $inicio = '16:00';
                    $fin = '17:00';
                }
            }
            
            
            $events[] = new \edofre\fullcalendar\models\Event([
                'id'               => $horario->id,
                'title'            => $horario->hora0->nombre.' - '.$horario->catedra0->division0->nombre.' - '.$agente,
                'start'            => $horario->fecha,
                'end'              => $horario->fecha,
                'startEditable'    => true,
                'color'            => $color,
                'url'              => 'index.php?r=clasevirtual/completoxcurso&division='.$horario->catedra0->division.'&vista=docentes&sem='.$horario->semana,
                'durationEditable' => true,]);*/
            if($doc->fechanac !=null){
                $fecha = explode("-",$doc->fechanac);
            
            for ($i=0; $i <= 1; $i++) { 
                $newfecha = date('Y')+$i."-".$fecha[1]."-".$fecha[2];
                $events[] = new \edofre\fullcalendar\models\Event([
                    'id'               => $doc->id,
                    'title'            => $doc->apellido.', '.$doc->nombre,
                    'start'            => $newfecha,
                    'end'              => $newfecha,
                    'startEditable'    => true,
                    //'color'            => $color,
                    'url'              => 'index.php?r=clasevirtual/completoxcurso&division='.$doc->id.'&vista=docentes&sem='.$doc->id,
                    'durationEditable' => true,]);
                }
            }
            
            
            
        }

        return $this->render('clasesvirtuales', [
            'selectable'  => true,
            'events' => $events
            /*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
        ]);
    }

    



}
