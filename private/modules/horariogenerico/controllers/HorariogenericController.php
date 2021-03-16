<?php

namespace app\modules\horariogenerico\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\Catedra;
use app\models\DetallecatedraSearch;
use app\models\Division;
use app\models\Hora;
use app\models\Horario;
use app\models\Nombramiento;
use app\models\Parametros;
use app\models\Preceptoria;
use app\models\Rolexuser;
use app\models\Semana;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\horariogenerico\models\Horareloj;
use Yii;
use app\modules\horariogenerico\models\Horariogeneric;
use app\modules\horariogenerico\models\HorariogenericSearch;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * HorariogenericController implements the CRUD actions for Horariogeneric model.
 */
class HorariogenericController extends Controller
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
                                    'printxdocente', 'deshabilitados', 'cambiarmovilidad', 'completodetallado', 'prueba', 'migrarhorariosiguienteanio', 'declaracionhorario', 'publicar', 'horassuperpuestasdj', 
                                    'generar', 'updateburbuja'],
                'rules' => [
                    [
                        'actions' => ['completoxdia', 'menuxdia', 'menuxdocente', 'menuxdocenteletra', 'menuxletra', 'panelprincipal', 'filtropormateria', 'horariocompleto', 'menuopciones'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR])){
                                        return true;
                                    }
                                    else{
                                        return false;
                                    }

                                    
                                }catch(\Exception $exception){
                                    return false;
                            }
                        },
                        

                    ],
                    [
                        'actions' => ['horarioclasespublic', 'completoxdocente'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR])){
                                        return true;
                                    }
                                    elseif(Yii::$app->user->identity->role == Globales::US_AGENTE){
                                        $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                        if($doc->id == Yii::$app->request->queryParams['agente']){
                                            return true;
                                        }
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
                        'actions' => ['completoxcurso', 'printxcurso'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{

                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_HORARIO, Globales::US_REGENCIA, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_COORDINACION])){
                                        return true;
                                    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                                        return true;
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
                                            return true;
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
                        'actions' => ['index', 'view', 'create', 'update', 'readlog', 'migrarhorarioprueba','prueba', 'migrarhorariosiguienteanio', ],   
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
                        'actions' => ['createdesdehorario','updatedesdehorario', 'generar', 'updateburbuja', 'printxdocente', 'deshabilitados', 'cambiarmovilidad', 'completodetallado', 'declaracionhorario', 'publicar'],   
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
                    [
                        'actions' => ['delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_AGENTE])){
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
                    
                    
                ],
            ],
        ];
    }

    /**
     * Lists all Horariogeneric models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HorariogenericSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horariogeneric model.
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
     * Creates a new Horariogeneric model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horariogeneric();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Horariogeneric model.
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
     * Deletes an existing Horariogeneric model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $division = $model->catedra0->division;
        $detcat = $model->catedra0->getDocentehorarioal0($model->aniolectivo);
        $agente = $detcat['agenteid'];
        $mail = $detcat['mail'];
        $semana = $model->semana;
        $model->delete();
        if(Yii::$app->user->identity->role == Globales::US_AGENTE && Yii::$app->user->identity->username == $mail)
            return $this->redirect(['/horariogenerico/horariogeneric/completoxdocente', 'agente' => $agente, 'sem' => $semana]);
        else
            return $this->redirect(['/horariogenerico/horariogeneric/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
        
    }

    /**
     * Finds the Horariogeneric model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horariogeneric the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horariogeneric::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPublicoshorarios($division, $vista, $prt=0, $sem=1, $ini=0){
        
        
        //$g = new Globales();
        //$this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $this->layout = '@app/views/layouts/mainhorariopublic';

        try {
            $sem = Semana::findOne($sem)->id;
        } catch (\Throwable $th) {
            $semana = Semana::find()
                        ->where(['<=','inicio',date('Y-m-d')])
                        ->andWhere(['>=','fin',date('Y-m-d')])
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

    public function actionCompletoxcurso($division, $vista, $prt=0, $sem=1, $ini=0){
        
        
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        try {
            $sem = Semana::findOne($sem)->id;
        } catch (\Throwable $th) {
            $semana = Semana::find()
                        ->where(['<=','inicio',date('Y-m-d')])
                        ->andWhere(['>=','fin',date('Y-m-d')])
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

    public function actionHorarioclasespublic($prt=0, $sem=null)
    {
        $estadopublicacion = Parametros::findOne(1)->estado;

        if ($estadopublicacion == 0){
            Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de clases");
            return $this->redirect(Yii::$app->request->referrer);
        }

        
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
            return $this->redirect(['menuxdivision']);
        }

        $alx2 = Aniolectivo::find()->where(['id' => $estadopublicacion])->one();

        $agente = Agente::find()->joinWith('detallecatedras')
                    ->where(['mail' => Yii::$app->user->identity->username])
                    ->andWhere(['=', 'detallecatedra.revista', 6])
                    ->andWhere(['=', 'detallecatedra.aniolectivo', $alx2->id])
                    ->one();

        if($agente == null){
            Yii::$app->session->setFlash('info', "No tiene horarios de clases asignados en su perfil de ".Yii::$app->user->identity->role0->nombre.'. Si desea acceder a los horarios como Preceptor/a o Jefe/a de Preceptor/a deberá cambiar su perfil de usuarios desde el menú.');
            return $this->redirect(['menuopcionespublic']);
        }


        try {
            $sem = Semana::find()->where(['id' => $sem])->andWhere(['publicada' => 1])->one()->id;
        } catch (\Throwable $th) {
            
            
            $semana = Semana::find()
                        ->where(['<=','inicio',date('Y-m-d')])
                        ->andWhere(['>=','fin',date('Y-m-d')])
                        ->andWhere(['publicada' => 1])
                        ->one();

            if($semana == null){
                $semana = Semana::find()
                        ->where(['>','inicio',date('Y-m-d')])
                        ->andWhere(['publicada' => 1])
                        ->all();
                if($semana != null){
                    $semana = min($semana);
                }else{
                    $semana = Semana::find()
                        ->andWhere(['publicada' => 1])
                        ->all();
                    $semana = max($semana);
                }
            }

            if($semana == null){
                Yii::$app->session->setFlash('info', "No está habilitada la sección de horarios de clases");
                return $this->redirect(Yii::$app->request->referrer);
            }else
                $sem= $semana->id;  
        }
        

        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        
        return $this->generarHorarioDocente($agente->id, $prt, $sem);
        
        
        //return $this->getCompletoxdocentepage($agente->id, 0, 0, 1, $alx2->id);
    }

    public function actionCompletoxdocente($agente, $prt=0, $sem=null, $ini=1){
        
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        try {
            $sem = Semana::findOne($sem)->id;
        } catch (\Throwable $th) {
            $semana = Semana::find()
                        ->where(['<=','inicio',date('Y-m-d')])
                        ->andWhere(['>=','fin',date('Y-m-d')])
                        ->one();
            
            if($semana == null){
                $semana = Semana::find()
                        ->where(['>','inicio',date('Y-m-d')])
                        ->all();
                $sem = min($semana)->id;
            }else
                $sem= $semana->id;
        }
        
        return $this->generarHorarioDocente($agente, $prt, $sem);
        /*if($ini == 1)
        {    $semana = Semana::find()
                        ->where(['<=','inicio',date('Y-m-d')])
                        ->andWhere(['>=','fin',date('Y-m-d')])
                        ->one();
            
            if($semana == null){
                $semana = Semana::find()
                        ->where(['>','inicio',date('Y-m-d')])
                        ->all();
                $sem = min($semana)->id;
            }else
                $sem= $semana->id;
        }
        //return $semana;
        return $this->generarHorarioDocente($agente, $prt, $sem);*/
    }

    public function actionUpdateburbuja($bur, $fecha, $division, $semana){
        $horarios = Horariogeneric::find()
                    ->joinWith(['catedra0'])
                    ->where(['fecha' => $fecha])
                    ->andWhere(['catedra.division' => $division])
                    ->all();
        foreach ($horarios as $horario) {
            $horario->burbuja = $bur;
            $horario->save();
        }
        return $this->redirect(['/horariogenerico/horariogeneric/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
    }

    public function generarHorarioCurso($division, $vista, $prt, $sem=0)
    {
        //$division = 1;
        //$dia = 3;

        $searchModel = new HorariogenericSearch();
        $paramdivision = Division::findOne($division);

        $anio = substr($paramdivision->nombre, 0, 1);

        //return $anio;

        $horareloj = Horareloj::find()
                        ->where(['semana' => $sem])
                        ->andWhere(['turno' => $paramdivision->turno])
                        ->andWhere(['anio' => $anio])
                        ->orderBy('hora')
                        ->all();
        $h= [];
        $conthora = 0;            
        foreach ($horareloj as $horarel) {
            $conthora ++;
            $hini = explode(':', $horarel->inicio);
            $hfin = explode(':', $horarel->fin);
            $h[$conthora] = $hini[0].':'.$hini[1].' - '.$hfin[0].':'.$hfin[1];
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
        
       

        
        try {
            if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
            
                $horarios = Horariogeneric::find()
                    ->joinWith(['catedra0'])
                    ->where(['semana' => $semana->id])
                    ->andWhere(['catedra.division' => $division])
                    ->orderBy('fecha')
                    ->all();
            }else{
                $horarios = Horariogeneric::find()
                    ->joinWith(['catedra0', 'semana0'])
                    ->where(['semana' => $semana->id])
                    ->andWhere(['catedra.division' => $division])
                    ->andWhere(['semana.publicada' => 1])
                    ->orderBy('fecha')
                    ->all();
            }
        } catch (\Throwable $th) {
            $horarios = Horariogeneric::find()
                    ->joinWith(['catedra0', 'semana0'])
                    ->where(['semana' => $semana->id])
                    ->andWhere(['catedra.division' => $division])
                    ->andWhere(['semana.publicada' => 1])
                    ->orderBy('fecha')
                    ->all();
        }
        
        if($semana->publicada == 0){
            Yii::$app->session->setFlash('danger', "No se encuentra publicada la semana");
        }
        
        

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
        //$horas = Hora::find()->where(['in', 'id', [2,3,4]])->all();
        $horas = $horareloj;
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

                $horarioxformat = Horariogeneric::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['semana' => $semana])
                    ->andWhere(['fecha' => $fechats])
                    ->all();

                    $burbujas = ArrayHelper::map($horarioxformat, 'burbuja', function($model){
                        try {
                            return $model->burbuja;
                        } catch (\Throwable $th) {
                            return '';
                        }
                        
                    });

                    $bur = '';

                    

                    if(count($burbujas)==0){
                        $colorcol = '#f1f1f1';
                    }elseif(count($burbujas)==1){
                        foreach ($burbujas as $burbuja) {
                            $colorcol = 'red';
                            $bur = $burbuja;
                            break;
                        }
                        if($bur == '')
                            $colorcol = 'green';
                        $colorcol = 'f1f1f1';
                    }else{
                        $colorcol = '#FFFF00';
                    }

                    $diaconmateria = false;
                    if($bur == 1){
                        $colorcol = '#f2dede';
                        $diaconmateria = true;
                    }
                    if($bur == 2){
                        $colorcol = '#ADD8E6';
                        $diaconmateria = true;
                    }
                    if($bur == 3){
                        $colorcol = '#FFFACD';
                        $diaconmateria = true;
                    }

                $dia = Yii::$app->formatter->asDate($dia, 'dd/MM/yyyy');
                try {
                    if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                        $botonera='<br />';
                        $botonera .= Html::a('<span class="button-red"></span>', Url::to(['updateburbuja', 'bur' => 1, 'fecha' => $fechats, 'division' => $division, 'semana' => $semana->id ]), ['style' => 'color:'.'red']);
                        $botonera .= ' '.Html::a('<span class="button-blue"></span>', Url::to(['updateburbuja', 'bur' => 2, 'fecha' => $fechats, 'division' => $division, 'semana' => $semana->id ]), ['style' => 'color:'.'blue']);
                        $botonera .= ' '.Html::a('<span class="button-yellow"></span>', Url::to(['updateburbuja', 'bur' => 3, 'fecha' => $fechats, 'division' => $division, 'semana' => $semana->id ]), ['style' => 'color:'.'#C7BC57']);
                    }else
                        $botonera = '';
                } catch (\Throwable $th) {
                    $botonera = '';
                }
                

                $diasgrid['columns'][] =  [
                            'header' => ($prt==1) ? $dias2[date("w",strtotime($fechats)-1)].'<br/>'.$dia : $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>'.$botonera,
                            'options' => [
                                'style' => 'background-color:'.$colorcol
                             ],
                            
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats,
                            /*'contentOptions' => function ($model, $key, $index, $column) use($colorcol) {
                                try {
                                    return ['style' => 'background-color:'.$colorcol ];
                                } catch (\Throwable $th) {
                                    //throw $th;
                                }
                                
                            },*/
                        ];
                

                foreach ($horas as $hora) {
                    # code...
                    if($cd == 0)
                        $array[$hora->hora][999] = $h[$ch+1]; 
                    
                    try {
                        if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                            if(($hora->hora != 2 && $hora->hora != 9) || $semana->tiposemana == 2){
                                if($prt==1)
                                    $array[$hora->hora][$fechats] = "-";
                                else
                                    //$array[$hora->hora][$fechats] = '<a class="btn btn-info btn-sm" href="?r=horariogenerico/horariogeneric/createdesdehorario&division='.$division.'&hora='.$hora->hora.'&fecha='.$fechats.'&semana='.$semana->id.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                                    $array[$hora->hora][$fechats] = Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['value' => Url::to(['/horariogenerico/horariogeneric/createdesdehorario', 'division' => $division, 'hora' => $hora->id, 'fecha' => $fechats, 'semana' => $semana->id]), 'title' => 'Modificar hora', 'class' => 'btn btn-info amodalgenerico']);
                            }else{
                                if($diaconmateria){
                                    if($hora->hora == 2)
                                        $array[$hora->hora][$fechats] = "Ingreso escalonado";
                                    else//9
                                        $array[$hora->hora][$fechats] = "Egreso escalonado";
                                }else{
                                    $array[$hora->hora][$fechats] = '-';
                                }
                            }
                            
                        }
                            
                        else{
                            if(($hora->hora != 2 && $hora->hora != 9) || $semana->tiposemana == 2)
                                $array[$hora->hora][$fechats] = "-";
                            else{
                                if($diaconmateria){
                                    if($hora->hora == 2)
                                        $array[$hora->hora][$fechats] = "Ingreso escalonado";
                                    else//9
                                        $array[$hora->hora][$fechats] = "Egreso escalonado";
                                }else{
                                    $array[$hora->hora][$fechats] = '-';
                                }
                            }
                        }
                    } catch (\Throwable $th) {
                        if(($hora->hora != 2 && $hora->hora != 9) || $semana->tiposemana == 2)
                        $array[$hora->hora][$fechats] = "-";
                        else{
                            if($diaconmateria){
                                if($hora->hora == 2)
                                    $array[$hora->hora][$fechats] = "Ingreso escalonado";
                                else//9
                                    $array[$hora->hora][$fechats] = "Egreso escalonado";
                            }else{
                                $array[$hora->hora][$fechats] = '-';
                            }
                        }
                    }
                    
                        
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
        $contaux = [];
        foreach ($horarios as $horariox) {
            $superpuesto = [];
                            foreach ($horariox->catedra0->detallecatedras as $dc) {

                                $salida = '';
                                if ($dc->revista == 6 && $dc->aniolectivo == $horariox->aniolectivo){
                                    //return var_dump($dc['revista']==1);
                                    $listdc[] = $dc->id;
                                    $cant = array_count_values($listdc)[$dc->id];
                                    
                                    
                                    $superpuesto = $this->horaSuperpuesta($dc, $horariox->horareloj0->hora, $horariox->fecha);
                                        
                                    
                                    if ($superpuesto[0]){
                                        //if($cant>1){
                                          //  $superpuesto[1] = str_replace('</ul>', $horariox->catedra0->division0->nombre."</ul>", $superpuesto[1]);
                                        //}
                                        ($horariox->horareloj0->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        $salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.$superpuesto[1].'">'.$dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1).'</span>'.'</span>';
                                    }
                                    else{
                                        //if($cant>1){
                                        //    ($horariox->horareloj0->hora < 6) ? $plac = 'bottom' : $plac = 'top';
                                        //$salida = '<span style="color:red">'.'<span rel="tooltip" data-toggle="tooltip" data-placement="'.$plac.'" data-html="true" data-title="'.'<ul>'.$horariox->catedra0->division0->nombre.'</ul>'.'">'.$dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1).'</span>'.'</span>';
                                        //}else{
                                            $salida = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);

                                        //}
                                    }
                                    
                                    break 1;
                                }else{
                                    $salida = 'Ed. Física';
                                }
                            }
                           
                           //return $salida;
            if(($horariox->horareloj0->hora != 2 && $horariox->horareloj0->hora != 9) || $semana->tiposemana == 2){//Egreso e ingreso
                try {
                    if($vista == 'docentes'){
                        if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                            if($prt==1)
                                $array[$horariox->horareloj0->hora][$horariox->fecha] = $salida;
                            else
                                //$array[$horariox->hora][$horariox->fecha] = $salida.'<div class="pull-right"><a class="btn btn-success btn-sm" href="?r=horarioexamen/updatedesdehorario&division='.$division.'&hora='.$horariox->hora.'&fecha='.$horariox->fecha.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>';
                                $array[$horariox->horareloj0->hora][$horariox->fecha] = Html::button($salida, ['value' => Url::to(['/horariogenerico/horariogeneric/updatedesdehorario', 'division' => $division, 'hora' => $horariox->horareloj, 'fecha' => $horariox->fecha, 'semana' => $semana->id]), 'title' => 'Modificar docente', 'class' => 'btn btn-link amodalgenerico']);
                        else
                            $array[$horariox->horareloj0->hora][$horariox->fecha] = $salida;
                    }else
                        $array[$horariox->horareloj0->hora][$horariox->fecha] = $horariox->catedra0->actividad0->nombre;
                } catch (\Throwable $th) {
                    $array[$horariox->horareloj0->hora][$horariox->fecha] = $horariox->catedra0->actividad0->nombre;
                }
                
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);
        //return var_dump($array);

        $docente_materia_search = new DetallecatedraSearch();
        $dataProvider = $docente_materia_search->horario_doce_divi_cant($division, $semana->aniolectivo);

        try {
            $columnpremitido = in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_HORARIO]);
            $origen = 'completoxcurso';
        } catch (\Throwable $th) {
            $columnpremitido = false;
            $origen = 'publicoshorarios';
        }
        try {
            $regenciapermitido = in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
        } catch (\Throwable $th) {
            $regenciapermitido = false;
        }
        try {
            $horariopremitido = in_array(Yii::$app->user->identity->role, [Globales::US_HORARIO]);
        } catch (\Throwable $th) {
            $horariopremitido = true;
        }

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
            'al' => $semana->aniolectivo,
            'semana' => $semana,
            'prt' => $prt,
            'listdc' => $listdc,
            'sem' => $sem,
            'sema' => $sema,
            'semn' => $semn,
            'columnpremitido' => $columnpremitido,
            'horariopremitido' => $horariopremitido,
            'regenciapermitido' => $regenciapermitido,
            'origen' => $origen,
            ]);

        //return var_dump($contaux);
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
            'columnpremitido' => $columnpremitido,
            'horariopremitido' => $horariopremitido,
            'regenciapermitido' => $regenciapermitido,
            'origen' => $origen,

        ]);
    }

    public function horaSuperpuesta($dc, $hora, $fecha){
        $docente = $dc->agente;
        $salida = '';
        $horarios = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'horareloj0'])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['<>', 'catedra.division', $dc->catedra0->division])
            ->andWhere(['horareloj.hora' => $hora])
            ->andWhere(['horariogeneric.fecha' => $fecha])
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
        $model = new Horariogeneric();
        //$model->scenario = $model::SCENARIO_CREATEHORARIO;
        $bur = null;
        $otrosmismodia = Horariogeneric::find()
                            ->joinWith(['catedra0'])
                            ->where(['fecha' => $fecha])
                            ->andWhere(['catedra.division' => $division])
                            ->all();
        foreach ($otrosmismodia as $otros) {
            $bur = $otros->burbuja;
        }

        $sem = Semana::findOne($semana);
        $model->horareloj = $hora;
        $model->fecha = $fecha;
        $model->semana = $semana;
        $model->burbuja = $bur;
        $model->diasemana = date("w",strtotime($model->fecha))+1;
        $model->aniolectivo = $sem->aniolectivo;
        //$dias2[date("w",strtotime($fechats)-1)];
        
        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            return $this->redirect(['/horariogenerico/horariogeneric/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
        }

        

        $catedras = Catedra::find()->where(['division' => $division])->all();
        $horas = Horareloj::find()->all();
        $division = Division::findOne($division);
        
        return $this->renderAjax('createdesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'catedras' => $catedras,
            'aniolectivo' =>$sem->aniolectivo,
        ]);
    }

    public function actionUpdatedesdehorario($division, $hora, $fecha, $semana)
    {
        $model = Horariogeneric::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['horareloj' => $hora])
                    ->andWhere(['semana' => $semana])
                    ->andWhere(['fecha' => $fecha])
                    ->one();
        

        if ($model->load(Yii::$app->request->post())) {
           //    $model->catedra = $model->catedra;

            //$model->anioxtrimestral = $alxtrim;
 
           $model->save();

           return $this->redirect(['/horariogenerico/horariogeneric/completoxcurso', 'division' => $division, 'vista' => 'docentes', 'sem' => $semana]);
        }

        $division = Division::findOne($division);
        $catedras = Catedra::find()->where(['division' => $division->id])->all();
        $horas = Horareloj::find()->all();
        //$dias = Diasemana::find()->all();
        
        return $this->renderAjax('updatedesdehorario', [
            'model' => $model,
            'horas' => $horas,
            'division' => $division,
            'aniolectivo' => $model->semana0->aniolectivo,
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
            $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horariogenerico/horariogeneric/panelprincipal&semana='.$semana->id.'&vista='.$vista.'" role="button" style="font-size:4vh; width:30vh; height: 15vh;">'.$semana->inicio.'</a>';
            $echodiv .= '</div><center>';
            $echodiv .= '</div>';

               
        }
        return $this->render('menuxsemana', [
            'echodiv' => $echodiv,
            
        ]);
    }

    public function actionPanelprincipal()
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        
        $infoexamen = "CLASES 2021 - Especiales";
        
        return $this->render('panelprincipal', [
            'infoexamen' => $infoexamen,
            
        ]);
    }

    public function actionMenudivipublic($col = 0)
    {
        $this->layout = '@app/views/layouts/mainhorariopublic';

        $divisiones = Division::find()
                                    ->where(['in', 'turno', [1,2]])
                                    ->andWhere(['<=', 'id', 53])
                                    ->orderBy('id')
                                    ->all();

        $vista = 'materias';
        
        $echodiv = '';
        foreach ($divisiones as $division) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                $echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horariogenerico/horariogeneric/publicoshorarios&division='.$division->id.'&vista='.$vista.'&prt=0&ini=1'.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivisionpublic', [
            'echodiv' => $echodiv,
            
        ]);
    }

    
    public function actionMenuxdivision($col = 0)
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
            $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();
        }else{
            $divisiones = Division::find()
                                    ->where(['in', 'turno', [1,2]])
                                    ->andWhere(['<=', 'id', 53])
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
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horariogenerico/horariogeneric/completoxcurso&division='.$division->id.'&vista='.$vista.'&prt=0&ini=1'.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
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
                $echodiv .= '<a class="menuHorarios" href="index.php?r=horariogenerico/horariogeneric/menuxdocenteletra&letra='.$letra.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$letra.'</a>';
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
                $echodiv .= '<center><a class="menuHorarios" href="index.php?r=horariogenerico/horariogeneric/completoxdocente&agente='.$doc->id.'" role="button" style="font-size:2.5vh; width:28vh; height: 20vh;">'.$doc->apellido.', '.$doc->nombre.'</a>';
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }

        return $this->render('menuxdocenteletra', [
            'echodiv' => $echodiv,
           
            
        ]);
    }

    public function actionReportexsemana($semana){

        $searchModel = new HorariogenericSearch();
        $dataProvider = $searchModel->reporteporsemana($semana);

        return $this->render('reportexsemana', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function generarHorarioDocente($docente, $prt, $sem=1)
    {
        //$division = 1;
        //$dia = 3;
        if(Yii::$app->user->identity->role == Globales::US_HORARIO)
            $this->layout = 'mainvacio';
       
        $docenteparam = Agente::findOne($docente);

        $semana = Semana::findOne($sem);

        if($semana->publicada == 0){
            Yii::$app->session->setFlash('danger', "No están publicados los horarios de la semana seleccionada");
        }

        try {
            $sema = $sem-1;
        } catch (\Throwable $th) {
            $sema = null;
        }

        try {
            $semn = $sem+1;
        } catch (\Throwable $th) {
            $semn = null;
        }

        
        $horarelojm = Horareloj::find()
                        ->where(['semana' => $sem])
                        
                        ->andWhere(['turno' => 1])
                        ->orderBy('hora')
                        ->all();

        

        $horarelojm =ArrayHelper::map($horarelojm, 'hora', function($model){
            $hini = explode(':', $model->inicio);
            $hfin = explode(':', $model->fin);
            return $hini[0].':'.$hini[1].' - '.$hfin[0].':'.$hfin[1];
        });

        
        
        $h= [];
        $j= [];
        $conthoram = 0;            
        foreach ($horarelojm as $key => $horarelm) {
            $conthoram ++;
            $h[$key] = $horarelm;
        }


        $horarelojt = Horareloj::find()
                        ->where(['semana' => $sem])
                        
                        ->andWhere(['turno' => 2])
                        ->orderBy('hora')
                        ->all();

        $horarelojt =ArrayHelper::map($horarelojt, 'hora', function($model){
            $hini = explode(':', $model->inicio);
            $hfin = explode(':', $model->fin);
            return $hini[0].':'.$hini[1].' - '.$hfin[0].':'.$hfin[1];
        });

        $j= [];
        $conthorat = 0;            
        foreach ($horarelojt as $key => $horarelt) {
            $conthorat ++;
            $j[$key] = $horarelt;
        }

        
        //return var_dump($h);
                  
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                
        $horariosTm = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'horareloj0', 'semana0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['detallecatedra.aniolectivo' => $semana->aniolectivo])
            ->andWhere(['division.turno' => 1])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariogeneric.semana' => $sem])
            
            ->orderBy('horariogeneric.fecha, horareloj.hora')
            ->all();

        $horariosTt = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'horareloj0', 'semana0'])
            //->where(['diasemana' => 2])
            ->where(['detallecatedra.agente' => $docente])
            ->andWhere(['detallecatedra.aniolectivo' => $semana->aniolectivo])
            ->andWhere(['division.turno' => 2])
            ->andWhere(['detallecatedra.revista' => 6])
            ->andWhere(['horariogeneric.semana' => $sem])
            
            ->orderBy('horariogeneric.fecha, horareloj.hora')
            ->all();
        }else{
                $horariosTm = Horariogeneric::find()
                ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'horareloj0', 'semana0'])
                //->where(['diasemana' => 2])
                ->where(['detallecatedra.agente' => $docente])
                ->andWhere(['detallecatedra.aniolectivo' => $semana->aniolectivo])
                ->andWhere(['division.turno' => 1])
                ->andWhere(['detallecatedra.revista' => 6])
                ->andWhere(['horariogeneric.semana' => $sem])
                ->andWhere(['semana.publicada' => 1])
                
                ->orderBy('horariogeneric.fecha, horareloj.hora')
                ->all();

                $horariosTt = Horariogeneric::find()
                    ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.division0', 'horareloj0', 'semana0'])
                    //->where(['diasemana' => 2])
                    ->where(['detallecatedra.agente' => $docente])
                    ->andWhere(['detallecatedra.aniolectivo' => $semana->aniolectivo])
                    ->andWhere(['division.turno' => 2])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->andWhere(['horariogeneric.semana' => $sem])
                    ->andWhere(['semana.publicada' => 1])
                    
                    ->orderBy('horariogeneric.fecha, horareloj.hora')
                    ->all();
        }
        
        
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
        //$horas = Hora::find()->where(['in', 'id', [2,3,4]])->all();
        $horas = $horarelojm;
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
            $ch = 1;
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

                //return var_dump($horas)    ;
                foreach ($horas as $key => $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTm[$key][999] = $h[$ch+1]; 
                    $arrayTm[$key][$fechats] = '';
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
                if($horarioxTm->burbuja == 1){
                    $span = '<span class="button-red" title="Burbuja roja"></span>';
                }elseif($horarioxTm->burbuja == 2){
                    $span = '<span class="button-blue" title="Burbuja azul"></span>';
                }elseif($horarioxTm->burbuja == 3){
                    $span = '<span class="button-yellow" title="Burbuja amarilla"></span>';
                }else{
                    $span = '';
                }
                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                    if($arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] != ''){
                        $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= ' - '.'<span style="color:red;">';
                        $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
            
                    }else{
                        $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
                    }
                }else{
                    if(Yii::$app->user->identity->username == $horarioxTm->catedra0->getDocentehorarioal0($horarioxTm->aniolectivo)['mail'])
                        if($horarioxTm->semana0->tiposemana == 2)
                            $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>'.
                            Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['delete', 'id' => $horarioxTm->id], [
                                'class' => 'btn btn-danger pull-right',
                                'data' => [
                                    'confirm' => 'Se dará de baja la clase, quiere proceder?',
                                    'method' => 'post',
                                ],
                            ]);
                        else
                            $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
                    else
                        $arrayTm[$horarioxTm->horareloj0->hora][$horarioxTm->fecha] .= $horarioxTm->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTm->catedra0->actividad0->nombre.'</span>';
                }
                
                
        }

        $providerTm = new ArrayDataProvider([
            'allModels' => $arrayTm,
            
        ]);
        
        $arrayTt = [];
        $salida = '';

        $dias = $range;
        //$horas = Hora::find()->where(['in', 'id', [2,3]])->all();
        $horas = $horarelojt;
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
            $ch = 1;
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
                foreach ($horas as $key => $hora) {
                    # code...
                    if($cd == 0)
                        $arrayTt[$key][999] = $j[$ch+1];
                    $arrayTt[$key][$fechats] = '';
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
            if($horarioxTt->burbuja == 1){
                    $span = '<span class="button-red" title="Burbuja roja"></span>';
                }elseif($horarioxTt->burbuja == 2){
                    $span = '<span class="button-blue" title="Burbuja azul"></span>';
                }elseif($horarioxTt->burbuja == 3){
                    $span = '<span class="button-yellow" title="Burbuja amarilla"></span>';
                }else{
                    $span = '';
                }
                            
                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])){
                    if($arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] != ''){
                        $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= ' - '.'<span style="color:red;">';
                        $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
            
                    }else{
                        $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
                    }
                }else{
                    if(Yii::$app->user->identity->username == $horarioxTt->catedra0->getDocentehorarioal0($horarioxTt->aniolectivo)['mail'])
                        if($horarioxTt->semana0->tiposemana == 2)
                            $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>'.
                            Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['delete', 'id' => $horarioxTt->id], [
                                'class' => 'btn btn-danger pull-right',
                                'data' => [
                                    'confirm' => 'Se dará de baja la clase, quiere proceder?',
                                    'method' => 'post',
                                ],
                            ]);
                        else
                            $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
                    else
                        $arrayTt[$horarioxTt->horareloj0->hora][$horarioxTt->fecha] .= $horarioxTt->catedra0->division0->nombre.' '.$span.'<br/>'.$horarioxTt->catedra0->actividad0->nombre.'</span>';
                }
        }

        $providerTt = new ArrayDataProvider([
            'allModels' => $arrayTt,
            
        ]);

        //return $sem;

        //return $sema;

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

    public function actionGenerar($semana, $anio, $turno){

        $sem = Semana::findOne($semana);
        $aniolectivo = $sem->aniolectivo;

        if($sem->tiposemana == 1)

            $horariosoriginales = Horario::find()
                                ->joinWith(['catedra0', 'catedra0.division0'])
                                ->where(['aniolectivo' => $aniolectivo])
                                ->andWhere(['LEFT(division.nombre, 1)' => $anio])
                                ->andWhere(['division.turno' => $turno])
                                ->andWhere(['horario.tipo' => 1])
                                ->andWhere(['<>','horario.hora', 2])
                                ->andWhere(['<>','horario.hora', 9])
                                ->andWhere(['<=', 'division.id', 53])
                                ->orderBy('horario.diasemana, hora')
                                ->all();
        else
            $horariosoriginales = Horario::find()
                ->joinWith(['catedra0', 'catedra0.division0'])
                ->where(['aniolectivo' => $aniolectivo])
                ->andWhere(['LEFT(division.nombre, 1)' => $anio])
                ->andWhere(['division.turno' => $turno])
                ->andWhere(['horario.tipo' => 1])
                ->andWhere(['<=', 'division.id', 53])
                ->orderBy('horario.diasemana, hora')
                ->all();
        
        //return var_dump($horariosoriginales);

        //return var_dump($sem->fechas);

        $fechas = $sem->fechas;
        $horasreloj = Horareloj::find()
                        ->where(['semana' => $sem->id])
                        ->andWhere(['anio' => $anio])
                        ->andWhere(['turno' => $turno])
                        ->all();
        
        $horasreloj = ArrayHelper::map($horasreloj, 'hora', 'id');

        //return var_dump($horasreloj);

        
        foreach ($horariosoriginales as $original) {
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
                $nuevoHorario->aniolectivo = $aniolectivo;
                $nuevoHorario->fecha = $fechas[$original->diasemana];
                $nuevoHorario->horareloj = $horasreloj[$original->hora];
                $nuevoHorario->save();
            
            
        }

        return $this->redirect(['/semana/view', 'id' => $sem->id, 'anio' => $anio, 'turno' =>$turno]);
        


    }
}
