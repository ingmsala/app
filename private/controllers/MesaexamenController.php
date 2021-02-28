<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\Actividadxmesa;
use app\models\Agente;
use app\models\Detallecatedra;
use app\models\Espacio;
use Yii;
use app\models\Mesaexamen;
use app\models\MesaexamenSearch;
use app\models\Tribunal;
use app\models\Turno;
use app\models\Turnoexamen;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\solicitudprevios\models\Detallesolicitudext;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\sortable\Sortable;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * MesaexamenController implements the CRUD actions for Mesaexamen model.
 */
class MesaexamenController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'mover', 'mover2', 'paso1', 'paso2', 'paso3'],
                'rules' => [
                    
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_PRECEPTOR, Globales::US_REGENCIA, Globales::US_SECRETARIA, Globales::US_HORARIO, Globales::US_CONSULTA, Globales::US_PRECEPTORIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view', 'create', 'update', 'delete', 'mover', 'mover2', 'paso1', 'paso2', 'paso3'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
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
     * Lists all Mesaexamen models.
     * @return mixed
     */
    public function actionIndex($turno, $all = 0)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
            $this->layout = 'mainpersonal';
            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        }
        else{
            $this->layout = 'main';
            $doc = null;
        }
            
        $searchModel = new MesaexamenSearch();
        $dataProvider = $searchModel->search($turno, $all);
        $turnoex = Turnoexamen::findOne($turno);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'turnoex' => $turnoex,
            'doc' => $doc,
            'all' => $all,
        ]);
    }

    /**
     * Displays a single Mesaexamen model.
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
     * Creates a new Mesaexamen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($turno)
    {
        $model = new Mesaexamen();
        $model->turnoexamen = $turno;

        $turnosexamen = Turnoexamen::find()->where(['id' => $turno])->all();
        $espacios = Espacio::find()->all();
        $docentes = Agente::find()->all();
        $actividades = Actividad::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            if($model->hora != null){
                if(strtotime($model->hora)<=strtotime('12:00:00')) {
                    $model->turnohorario = 1;
                   } else {
                    $model->turnohorario = 2;
                   }
            }else{
                $model->turnohorario = null;
            }

            $model->save();

            $doc = Yii::$app->request->post()['docentes'];
            $act = Yii::$app->request->post()['actividades'];

            foreach ($doc as $d) {
                $tribunal = new Tribunal();
                $tribunal->mesaexamen = $model->id;
                $tribunal->agente = $d;
                $tribunal->save();
            }

            foreach ($act as $a) {
                $actividadxmesa = new Actividadxmesa();
                $actividadxmesa->mesaexamen = $model->id;
                $actividadxmesa->actividad = $a;
                $actividadxmesa->save();
            }
            
            //return var_dump(Yii::$app->request->post());
            return $this->redirect(['index', 'turno' => $model->turnoexamen]);
            
        }

        return $this->render('create', [
            'model' => $model,
            'turnosexamen' => $turnosexamen,
            'espacios' => $espacios,
            'docentes' => $docentes,
            'actividades' => $actividades,
        ]);
    }

    /**
     * Updates an existing Mesaexamen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $or='aj')
    {
        $model = $this->findModel($id);
        if($or=='in')
            $model->scenario = Mesaexamen::SCENARIO_AMB;
        elseif($or=='p2')
            $model->scenario = Mesaexamen::SCENARIO_AMB;
        elseif($or=='p3')
            $model->scenario = Mesaexamen::SCENARIO_AMB;
        else
            $model->scenario = Mesaexamen::SCENARIO_PASOS;

        $turnosexamen = Turnoexamen::find()->all();
        $espacios = Espacio::find()->all();
        $docentes = Agente::find()->all();

        $al = Aniolectivo::find()->where(['activo' => 1])->one();
        
        $doce = [];
        $acti = ArrayHelper::map($model->actividads, 'id', 'id');
        $docentes_actividades = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->andWhere(['in', 'actividad.id', $acti])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $al->id])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();

            $doce['Docentes de las materias']=[];
            foreach ($docentes_actividades as $dc) {
                $doce['Docentes de las materias'][$dc->agente0->id] = $dc->agente0->getNombreCompleto();
            }

        /*$docente_act = array_column($docentes_actividades, 'agente');
        $agentes = Agente::find()
            ->where(['not in', 'id', $docente_act])
            ->orderBy('apellido, nombre')
            ->all();*/
        //return var_dump(array_keys($doce['Docentes de las materias']));
        $otrosdc = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->andWhere(['not in', 'actividad.id', $acti])
            ->andWhere(['not in', 'agente.id', array_keys($doce['Docentes de las materias'])])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $al->id])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();
            
        
        foreach ($otrosdc as $odt) {
            $doce['Otros docentes'][$odt->agente0->id] = $odt->agente0->getNombreCompleto();
        }

            
        

        $actividades = Actividad::find()->all();

        $actividadesxmesa = Actividadxmesa::find()->where(['mesaexamen' => $id])->all();
        $tribunal = Tribunal::find()->where(['mesaexamen' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {

            try {
                $desdeexplode = explode("/",$model->fecha);
                $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
                $model->fecha = $newdatedesde;
            } catch (\Throwable $th) {
                $model->fecha = null;
            }
            

            if($model->hora != null){
                if(strtotime($model->hora)<=strtotime('12:00:00')) {
                    $model->turnohorario = 1;
                   } else {
                    $model->turnohorario = 2;
                   }
            }else{
                $model->turnohorario = null;
            }

            $model->save();

            try {
                $doc = Yii::$app->request->post()['docentes'];
                foreach ($tribunal as $tr) {
                    $tr->delete();
                }

                foreach ($doc as $d) {
                    $tribunal = new Tribunal();
                    $tribunal->mesaexamen = $model->id;
                    $tribunal->agente = $d;
                    $tribunal->save();
                }
            } catch (\Throwable $th) {
                foreach ($tribunal as $tr) {
                    $tr->delete();
                }
            }
            

            try {
                $act = Yii::$app->request->post()['actividades'];

                foreach ($actividadesxmesa as $am) {
                    $am->delete();
                }

                foreach ($act as $a) {
                    $actividadxmesa = new Actividadxmesa();
                    $actividadxmesa->mesaexamen = $model->id;
                    $actividadxmesa->actividad = $a;
                    $actividadxmesa->save();
                }
            } catch (\Throwable $th) {
                foreach ($actividadesxmesa as $am) {
                    $am->delete();
                }
            }

            
            if($or=='in')
                return $this->redirect(['index', 'turno' => $model->turnoexamen, 'all' => 1]);
            elseif($or=='p2')
                return $this->redirect(['paso2', 'turno' => $model->turnoexamen]);
            elseif($or=='p3')
                return $this->redirect(['paso3', 'turno' => $model->turnoexamen]);
            else
                return $this->redirect(['paso1', 'turno' => $model->turnoexamen]);
        }

        try {
            $desdeexplode = explode("-",$model->fecha);
            $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
            $model->fecha = $newdatedesde;
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'turnosexamen' => $turnosexamen,
                'espacios' => $espacios,
                'docentes' => $docentes,
                'actividades' => $actividades,
                'actividadesxmesa' => $actividadesxmesa,
                'tribunal' => $tribunal,
                'origen' => 'ajax',
                'or' => $or,
                'doce' => $doce,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'turnosexamen' => $turnosexamen,
            'espacios' => $espacios,
            'docentes' => $docentes,
            'actividades' => $actividades,
            'actividadesxmesa' => $actividadesxmesa,
            'origen' => 'noajax',
            'tribunal' => $tribunal,
            'or' => $or,
            'doce' => $doce,
        ]);
    }

    /**
     * Deletes an existing Mesaexamen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $or = 'aj')
    {
        $model = $this->findModel($id);
        $turno = $model->turnoexamen;
        $model->delete();

        if($or=='in')
                return $this->redirect(['index', 'turno' => $turno, 'all' => 1]);
            elseif($or=='p2')
                return $this->redirect(['paso2', 'turno' => $turno]);
            elseif($or=='p3')
                return $this->redirect(['paso3', 'turno' => $turno]);
            else
                return $this->redirect(['paso1', 'turno' => $turno]);
    }

    public function actionEnviarrecordatorio(){

        $ahora = time();
        $unDiaEnSegundos = 24 * 60 * 60;
        $manana = $ahora + $unDiaEnSegundos;
        $mananaLegible = date("Y-m-d", $manana);

        $mesasTomorrow = Mesaexamen::find()->all();//->where(['fecha' => $mananaLegible])->all();

        $tribunalesTomorrow = Tribunal::find()->where(['agente' => 38])->all();//->where(['in', 'mesaexamen', array_column($mesasTomorrow,'id')])->all();

        $agentes=ArrayHelper::map($tribunalesTomorrow,'agente','agente');

        
        $echogrid = '';
        foreach ($agentes as $agente) {
            

            $mesasTomorrowDocenteX = Mesaexamen::find()
                                        ->joinWith(['tribunals'])
                                        ->where(['in', 'mesaexamen', array_column($mesasTomorrow,'id')])
                                        ->andWhere(['tribunal.agente' => $agente]);
            //$arrayprueba[] = $mesasTomorrowDocenteX;

            $dataProvider = new ActiveDataProvider([
                'query' => $mesasTomorrowDocenteX,
            ]);

            $echogrid = GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    //'heading' => Html::encode($turnoex->nombre),
                    //'beforeOptions' => ['class'=>'kv-panel-before'],
                ],
                'summary' => false,
        
                
        
                'toolbar'=>[
                    ['content' =>''
                    ],
                   
                    
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
        
                    //'nombre',
                    [
                        'label' => 'Fecha',
                        'attribute' => 'fecha',
                        'format' => 'raw',
                        'value' => function($model){
                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                           if ($model['fecha'] == date('Y-m-d')){
                                return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                           } 
                           return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                        }
                    ],
                    
                    [
                        'label' => 'Hora',
                        'value' => function($model){
                            $hora = explode(':', $model->hora);
                            return $hora[0].':'.$hora[1].' hs.';
                        }
                    ],
        
                    [
                        'label' => 'Asignaturas',
                        'format' => 'raw',
                        'value' => function($model){
                            $salida = '<ul>';
                            $activxmesa = Actividadxmesa::find()->where(['mesaexamen' => $model->id])->all();
        
                            foreach ($activxmesa as $actividadxmesa) {
                                $salida .= '<li>'.$actividadxmesa->actividad0->nombre.'</li>';
                            }
        
                            $salida .= '</ul>';
                            return $salida;
                        }
                    ],
                    [
                        'label' => 'Tribunal',
                        'format' => 'raw',
                        'value' => function($model) use ($agente){
                            $salida = '<ul>';
                            $trib = Tribunal::find()->where(['mesaexamen' => $model->id])->all();
        
                            foreach ($trib as $tribunal) {
                                try {
                                    if($agente == $tribunal->agente){
                                        $salida .= '<li><span style="background-color: #FFaaFF;">'.$tribunal->agente0->apellido.', '.substr(ltrim($tribunal->agente0->nombre),0,1).'</span></li>';
                                    }else{
                                        $salida .= '<li>'.$tribunal->agente0->apellido.', '.substr(ltrim($tribunal->agente0->nombre),0,1).'</li>';
                                    }
                                } catch (\Throwable $th) {
                                    $salida .= '<li>'.$tribunal->agente0->apellido.', '.substr(ltrim($tribunal->agente0->nombre),0,1).'</li>';
                                }
                                
        
                                
                            }
        
                            $salida .= '</ul>';
                            return $salida;
                        }
                    ],
                    //'espacio',
        
                    
                ],
            ]);
            
            /*$sendemail=Yii::$app->mailer->compose()
                        
                        ->setFrom([Globales::MAIL => 'Recordatorio'])
                        ->setTo('msala@unc.edu.ar')
                        ->setSubject('Feliz cumple')
                        ->setHtmlBody('<img style="border: 0;display: block;height: auto;width: 100%;max-width: 480px;" alt="<Feliz cumpleaños" width="480" src="https://admin.cnm.unc.edu.ar/front/assets/images/fc.jpg" />')
                        ->send();
        */
        
        }

        $sendemail=Yii::$app->mailer->compose()
                        
                        ->setFrom([Globales::MAIL => 'Información - Previas'])
                        ->setTo('msala@unc.edu.ar')
                        ->setSubject('Recordatorio mesa de examen')
                        ->setHtmlBody($echogrid)
                        ->send();

        return var_dump($echogrid);

    }

    public function actionPaso1($turno)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_PRECEPTOR])){
            $this->layout = 'mainpersonal';
            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        }
        else{
            $this->layout = 'main';
            $doc = null;
        }

        $sql = Mesaexamen::find()->where(['turnoexamen' => $turno]);

        $mesas = new ActiveDataProvider([
            'query' => $sql,
        ]);
        $actividadxmesa = Actividadxmesa::find()->joinWith(['mesaexamen0'])->where(['mesaexamen.turnoexamen' => $turno])->all();
        $axm = ArrayHelper::map($actividadxmesa, 'actividad', 'actividad');

        $solicitudes = Detallesolicitudext::find()
                        ->select('actividad.id, actividad.nombre as materia, count(actividad) as cant')
                        ->joinWith(['solicitud0', 'actividad0', 'estado0'])
                        ->groupBy('actividad.id, actividad.nombre')
                        ->where(['solicitudinscripext.turno' => $turno])
                        ->andWhere(['not in', 'actividad.id', $axm])
                        ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
                        ->all();

        $solicitudesX = Detallesolicitudext::find()
        ->select('actividad.id, actividad.nombre as materia, count(actividad) as cant')
        ->joinWith(['solicitud0', 'actividad0', 'estado0'])
        ->groupBy('actividad.id, actividad.nombre')
        ->where(['solicitudinscripext.turno' => $turno])
        ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
        ->all();

        $solicitudesTodas = ArrayHelper::map($solicitudesX, 'id', function($model){
            return $model->cant;
        });
                        
        $materias = ArrayHelper::map($solicitudes, 'id', function($model){
            return '<div class="btn btn-primary">'.$model->materia.' <span class="badge">'.$model->cant.'</span></div>';
        });
        
        $mat = Actividad::find()->where(['in', 'id', array_keys($materias)])->orderBy('departamento, nombre')->all();

        /*$materias = ArrayHelper::map($solicitudes, 'actividad', function($model){
            return $model->actividad0->nombre;
        });*/
        $materiasdisponibles = array_replace(ArrayHelper::map($mat, 'id', 'id'), $materias);

        $model = new Mesaexamen();

        $model->scenario = Mesaexamen::SCENARIO_PASOS;
        $model->turnoexamen = $turno;

        $modelAxM = new Actividadxmesa();

        $turno = Turnoexamen::findOne($turno);

        if ($modelAxM->load(Yii::$app->request->post())) {
            
            if($model->save()){

                $activ = Yii::$app->request->post()['Actividadxmesa']['actividad'];

                foreach ($activ as $act) {
                    $modelAxMx = new Actividadxmesa();
                    $modelAxMx->mesaexamen = $model->id;
                    $modelAxMx->actividad = $act;
                    $modelAxMx->save();
                }

            }

            return $this->redirect(['paso1', 'turno' => $turno->id]);
        }

        return $this->render('paso1', [
            'model' => $model,
            'modelAxM' => $modelAxM,
            'materiasdisponibles' => $materiasdisponibles,
            'solicitudesTodas' => $solicitudesTodas,
            'actividadxmesa' => $actividadxmesa,
            'mesas' => $mesas,
            'turno' => $turno,
        ]);
        
    }

    public function actionMover($mesa, $dir)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $mesa = Mesaexamen::findOne($mesa);

        $diaanterior =strtotime ( '-1 day' , strtotime ( $mesa->fecha ) );
        $diasiguiente =strtotime ( '+1 day' , strtotime ( $mesa->fecha ) );

        //$diaanterior = date('d/m/Y', $diaanterior);

        //Yii::$app->session->setFlash('danger', $diaanterior.' - '.$diasiguiente);
        //return $this->redirect(['paso2', 'turno' => $mesa->turnoexamen0->id]);
        

        if(($mesa->turnohorario == 1 && $dir == 'u') || ($mesa->turnohorario == 2 && $dir == 'd')
             || ($diaanterior < strtotime ($mesa->turnoexamen0->desde) && $dir == 'l')
             || ($diasiguiente > strtotime ($mesa->turnoexamen0->hasta) && $dir == 'r')){
                Yii::$app->session->setFlash('danger', "No se puede mover la mesa en esa dirección");
                 return $this->redirect(['paso2', 'turno' => $mesa->turnoexamen0->id]);
             }
             
        if($mesa->turnohorario == 1 && $dir == 'd'){
            $mesa->hora = '13:30';
            $mesa->turnohorario = 2;
        }
        if($mesa->turnohorario == 2 && $dir == 'u'){
            $mesa->hora = '08:00';
            $mesa->turnohorario = 1;
        }
        if($dir == 'r'){
            $mesa->fecha = date('Y-m-d', $diasiguiente);
        }
        if($dir == 'l'){
            $mesa->fecha = date('Y-m-d', $diaanterior);
        }
        $mesa->save();

        return $this->redirect(['paso2', 'turno' => $mesa->turnoexamen0->id]);
    }

    public function actionPaso2($turno)
    {
       
        $turnoX = Turnoexamen::findOne($turno);
        $start = $turnoX->desde;
        $end = $turnoX->hasta;

        $solicitudesX = Detallesolicitudext::find()
        ->select('actividad.id, actividad.nombre as materia, count(actividad) as cant')
        ->joinWith(['solicitud0', 'actividad0', 'estado0'])
        ->groupBy('actividad.id, actividad.nombre')
        ->where(['solicitudinscripext.turno' => $turno])
        ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
        ->all();

        $solicitudesTodas = ArrayHelper::map($solicitudesX, 'id', function($model){
            return $model->cant;
        });

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        //return var_dump($range);

        $dias = $range;

        $turnocursado = Turno::find()->where(['<', 'id', 3])->all();
        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        $diasgrid = [];
        //$diasgrid['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgrid['columns'][] =[
                        'label' => 'Turno',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        //'attribute' => '999',
                        'value' => function($model) {
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
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                

                foreach ($turnocursado as $turnocur) {
                    # code...
                    if($cd == 0)
                        $array[$turnocur->id][999] = $turnocur->nombre; 
                    /*if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                        if($prt==1)
                            $array[$hora->id][$fechats] = "-";
                        else
                            $array[$hora->id][$fechats] = '<a class="btn btn-info btn-sm" href="?r=horarioexamen/createdesdehorario&division='.$division.'&hora='.$hora->id.'&fecha='.$fechats.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                    else*/
                        $array[$turnocur->id][$fechats] = "";
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

        $mesas = Mesaexamen::find()->where(['turnoexamen' => $turnoX->id])->orderBy('fecha, hora')->all();

        $salida = '';
        $listdc = [];
        $cmf = 0;
        $cmh = 0;
       
        $punterofecha = strtotime ( $turnoX->desde );
        $punterohora = 1;
        foreach ($mesas as $mesa) {
            if($mesa->fecha == null){
                $mesa->fecha = date('Y-m-d', $punterofecha);
                $mesa->save();
                $punterofecha = strtotime ( '+1 day' , $punterofecha);
                if($punterofecha>strtotime ($turnoX->hasta))
                    $punterofecha = strtotime ($turnoX->desde);
            }
            if($mesa->hora == null){
                $mesa->turnohorario = $punterohora;
                if($punterohora == 1){
                    $mesa->hora = '08:00';
                    $punterohora = 2;
                }
                else{
                    $mesa->hora = '13:30';
                    $punterohora = 1;
                }
                
                $mesa->save();
                
            }

            $horaX = explode(':', $mesa->hora);
            $horaX = ' - '.$horaX[0].':'.$horaX[1].'hs.';

            $salida = '<ul>';
        $superposision = false;
        if($mesa->fecha != null && $mesa->hora != null){
            if($mesa->repetidos == "Sin inscripciones"){
                $salida = "Sin inscripciones";
                $tipopanel = DetailView::TYPE_DEFAULT;
            }else{
                foreach ($mesa->repetidos as $key => $detalle) {
                    # code...
                    $det = Detallesolicitudext::findOne($key);
                    $salida .= '<li>'.$det->solicitud0->apellido.', '.$det->solicitud0->nombre.'</li>';
        
                    //$mesas = array_column($detalle,'0');
                    $salida .= '<ul>';
                    foreach ($detalle as $mesaX) {
                        //return var_dump($mesa);
                        try {
                            $salida .= '<li>Mesa #'.$mesaX->id.'</li>';
                            $superposision = true;
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                            
                        
                    }
                    $salida .= '</ul>';
                }
                $salida .= '</ul>';

                if($superposision){
                    $tipopanel = DetailView::TYPE_DANGER;
                }else{
                    $tipopanel = DetailView::TYPE_SUCCESS;
                    $salida = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }
            }
        }

        if($mesa->fecha == null || $mesa->hora == null){
            $tipopanel = DetailView::TYPE_PRIMARY;
        }
            
            $salida = DetailView::widget([
                'model'=>$mesa,
                'condensed'=>true,
                //'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'enableEditMode' => false,
                'panel'=>[
                    'heading'=>'Mesa #'.$mesa->id.Html::button($horaX, ['value' => Url::to(['update', 'id' => $mesa->id, 'or' => 'p2']), 'title' => 'Modificar mesa de examen'.' #'.$mesa->id, 'class' => 'btn btn-link amodalcasoupdate']),
                    'headingOptions' => [
                        'template' => '',
                    ],
                    'type'=>$tipopanel,
                ],
                'attributes'=>[
                    
                    //'turnohorario',
                    [
                        'label' => 'Materias',
                        'format' => 'raw',
                        'value' => function($model) use ($mesa, $solicitudesTodas){
                            //return var_dump($solicitudesTodas);
                            $salida = '<ul>';
                            foreach ($mesa->actividads as $actividad) {
                                try {
                                    $salida .= '<li>'.$actividad->nombre.'<b> - Inscriptos: '.Html::button($solicitudesTodas[$actividad->id], ['value' => Url::to(['/solicitudprevios/detallesolicitudext/pormateria', 'turno' => $mesa->turnoexamen, 'actividad' => $actividad->id]), 'title' => 'Inscriptos en la materia '.$actividad->nombre, 'class' => 'btn btn-link amodalcasoupdate']).'</b></li>';
                                } catch (\Throwable $th) {
                                    $salida .= '<li>'.$actividad->nombre.'</li>';
                                }
                                
                            }
                            $salida .= '</ul>';
                            return $salida;
                        }
                    ],
                    [
                        'label' => 'Superposición'.'<br /> <center><span style="color:red" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></center>',
                        'format' => 'raw',
                        'visible' => $superposision,
                        'value' => function($model) use ($salida){
                            return $salida;
                            
                        }
                    ],
                    
                    [
                        'label' => 'Mover',
                        'format' => 'raw',
                        'value' => function($model) use ($mesa){
                            
                            $arriba = Html::a('<span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'u']), ['class' => 'btn btn-default']);
                            $derecha = Html::a('<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'r']), ['class' => 'btn btn-default']);
                            $izquierda = Html::a('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'l']), ['class' => 'btn btn-default']);
                            $abajo = Html::a('<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'd']), ['class' => 'btn btn-default']);

                            return $arriba.'<br>'.$izquierda.$abajo.$derecha;
                            
                        }
                    ]
                    
                   
                ]
            ]);
                            
            $array[$mesa->turnohorario][$mesa->fecha] .= $salida;
        }

        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);

        return $this->render('paso2', [

            'provider' => $provider,
            'diasgrid' => $diasgrid,
            'listdc' => $listdc,
            'turno' => $turnoX,

        ]);
    }

    public function actionMover2($destino, $origen, $mesa){

        //$destion;
        $cambio = false;
        $destino2=substr($destino, 1, strlen($destino));
        $expl = explode('-',$destino2);
        $fecha = date('Y-m-d', $expl[0]);
        $turnohorario = $expl[1];

        $mesaexamenX = Mesaexamen::findOne($mesa);
        if($mesaexamenX->turnohorario != $turnohorario){
            $cambio = true;
            if($turnohorario == 1){
                $mesaexamenX->hora = '08:00';
            }else{
                $mesaexamenX->hora = '13:30';
            }
        }
        if($mesaexamenX->fecha != $fecha){
            $cambio = true;
        }
        if($cambio){
            $mesaexamenX->turnohorario = $turnohorario;
            $mesaexamenX->fecha = $fecha;
            $mesaexamenX->save();
        }else{
            $cambio = 'sin cambios';
        }
       

        return $cambio;

    }

    public function actionPaso3($turno)
    {
       
        $turnoX = Turnoexamen::findOne($turno);
        $start = $turnoX->desde;
        $end = $turnoX->hasta;

        $solicitudesX = Detallesolicitudext::find()
        ->select('actividad.id, actividad.nombre as materia, count(actividad) as cant')
        ->joinWith(['solicitud0', 'actividad0', 'estado0'])
        ->groupBy('actividad.id, actividad.nombre')
        ->where(['solicitudinscripext.turno' => $turno])
        ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
        ->all();

        $solicitudesTodas = ArrayHelper::map($solicitudesX, 'id', function($model){
            return $model->cant;
        });

        $range = [];



        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        } while($start <= $end);

        //return var_dump($range);

        $dias = $range;

        $turnocursado = Turno::find()->where(['<', 'id', 3])->all();
        $cd = 0;
        //return var_dump($dias);
        $array = [];
        $salida = '';
        $diasgrid = [];
        //$diasgrid['columns'][] =['class' => 'yii\grid\SerialColumn'];
        $diasgrid['columns'][] =[
                        'label' => 'Turno',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        //'attribute' => '999',
                        'value' => function($model) {
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
                            'header' => $dias2[date("w",strtotime($fechats)-1)].'<br/>'.'<span class="label label-primary">'.$dia.'</span>',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'format' => 'raw',
                            'attribute' => $fechats
                            /*'value' => function($model){
                                return var_dump($model);
                            }*/
                        ];
                

                foreach ($turnocursado as $turnocur) {
                    # code...
                    if($cd == 0)
                        $array[$turnocur->id][999] = $turnocur->nombre; 
                    
                        $array[$turnocur->id][$fechats] = '';
                    
                    $ch = $ch + 1;
                }  
            }
            
            $cd = $cd + 1;
        }
        //return var_dump($array);

        $mesas = Mesaexamen::find()->where(['turnoexamen' => $turnoX->id])->orderBy('fecha, hora')->all();

        $salida = '';
        $listdc = [];
        $cmf = 0;
        $cmh = 0;
       
        $punterofecha = strtotime ( $turnoX->desde );
        $punterohora = 1;
        $item = [];
        foreach ($mesas as $mesa) {
            if($mesa->fecha == null){
                $mesa->fecha = date('Y-m-d', $punterofecha);
                $mesa->save();
                $punterofecha = strtotime ( '+1 day' , $punterofecha);
                if($punterofecha>strtotime ($turnoX->hasta))
                    $punterofecha = strtotime ($turnoX->desde);
            }
            if($mesa->hora == null){
                $mesa->turnohorario = $punterohora;
                if($punterohora == 1){
                    $mesa->hora = '08:00';
                    $punterohora = 2;
                }
                else{
                    $mesa->hora = '13:30';
                    $punterohora = 1;
                }
                
                $mesa->save();
                
            }

            $horaX = explode(':', $mesa->hora);
            $horaX = ' - '.$horaX[0].':'.$horaX[1].'hs.';

            $salida = '<ul>';
        $superposision = false;
        if($mesa->fecha != null && $mesa->hora != null){
            if($mesa->repetidos == "Sin inscripciones"){
                $salida = "Sin inscripciones";
                $tipopanel = DetailView::TYPE_DEFAULT;
            }else{
                foreach ($mesa->repetidos as $key => $detalle) {
                    # code...
                    $det = Detallesolicitudext::findOne($key);
                    $salida .= '<li>'.$det->solicitud0->apellido.', '.$det->solicitud0->nombre.'</li>';
        
                    //$mesas = array_column($detalle,'0');
                    $salida .= '<ul>';
                    foreach ($detalle as $mesaX) {
                        //return var_dump($mesa);
                        try {
                            $salida .= '<li>Mesa #'.$mesaX->id.'</li>';
                            $superposision = true;
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                            
                        
                    }
                    $salida .= '</ul>';
                }
                $salida .= '</ul>';

                if($superposision){
                    $tipopanel = DetailView::TYPE_DANGER;
                }else{
                    $tipopanel = DetailView::TYPE_SUCCESS;
                    $salida = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }
            }
        }

        if($mesa->fecha == null || $mesa->hora == null){
            $tipopanel = DetailView::TYPE_PRIMARY;
        }
           //$item = [];
            $item[strtotime($mesa->fecha).'-'.$mesa->turnohorario][] = ['options' =>['id'=>$mesa->id], 'content' => DetailView::widget([
                'model'=>$mesa,
                'condensed'=>true,
                //'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'enableEditMode' => false,
                'panel'=>[
                    'heading'=>'Mesa #'.$mesa->id.Html::button($horaX, ['value' => Url::to(['update', 'id' => $mesa->id, 'or' => 'p3']), 'title' => 'Modificar mesa de examen'.' #'.$mesa->id, 'class' => 'btn btn-link amodalcasoupdate']),
                    'headingOptions' => [
                        'template' => '',
                    ],
                    'type'=>$tipopanel,
                ],
                'attributes'=>[
                    
                    //'turnohorario',
                    [
                        'label' => 'Materias',
                        'format' => 'raw',
                        'value' => function($model) use ($mesa, $solicitudesTodas){
                            //return var_dump($solicitudesTodas);
                            $salida = '<ul>';
                            foreach ($mesa->actividads as $actividad) {
                                try {
                                    $salida .= '<li>'.$actividad->nombre.'<b> - Inscriptos: '.Html::button($solicitudesTodas[$actividad->id], ['value' => Url::to(['/solicitudprevios/detallesolicitudext/pormateria', 'turno' => $mesa->turnoexamen, 'actividad' => $actividad->id]), 'title' => 'Inscriptos en la materia '.$actividad->nombre, 'class' => 'btn btn-link amodalcasoupdate']).'</b></li>';
                                } catch (\Throwable $th) {
                                    $salida .= '<li>'.$actividad->nombre.'</li>';
                                }
                                
                            }
                            $salida .= '</ul>';
                            return $salida;
                        }
                    ],
                    [
                        'label' => 'Superposición'.'<br /> <center><span style="color:red" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></center>',
                        'format' => 'raw',
                        'visible' => $superposision,
                        'value' => function($model) use ($salida){
                            return $salida;
                            
                        }
                    ],
                    
                    /*[
                        'label' => 'Mover',
                        'format' => 'raw',
                        'value' => function($model) use ($mesa){
                            
                            $arriba = Html::a('<span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'u']), ['class' => 'btn btn-default']);
                            $derecha = Html::a('<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'r']), ['class' => 'btn btn-default']);
                            $izquierda = Html::a('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'l']), ['class' => 'btn btn-default']);
                            $abajo = Html::a('<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>', Url::to(['mover', 'mesa' => $mesa->id, 'dir' => 'd']), ['class' => 'btn btn-default']);

                            return $arriba.'<br>'.$izquierda.$abajo.$derecha;
                            
                        }
                    ]*/
                    
                   
                ]
            ])
                    ];

                    /*$salida = Sortable::widget([
                        'options' =>[
                            'id' => 'w'.$mesa->id,
                        ],
                        'showHandle'=>true,
                        'connected'=>true,
                        'items'=>$item,
                        'pluginEvents' => [
                            'sortupdate' => 'function(e) { console.log(e.detail); }',
                        ]
                    ]); */
                            
            //$array[$mesa->turnohorario][$mesa->fecha] .= $salida;
        }

        //return var_dump($item['1615172400-1']);

        

        foreach ($dias as $dia2) {
            
            $fechats = $dia2;
            

            //return var_dump(strtotime($dia));

            if (!in_array(date("w",strtotime($fechats)), [0,6])){
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                
                //$dia2 = Yii::$app->formatter->asDate($dia2, 'dd/MM/yyyy');
                                
                
                foreach ($turnocursado as $turnocur) {
                    
                    # code...
                    /*if($cd == 0)
                        $array2[$turnocur->id][999] = $turnocur->nombre; */
                    /*if (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]))
                        if($prt==1)
                            $array[$hora->id][$fechats] = "-";
                        else
                            $array[$hora->id][$fechats] = '<a class="btn btn-info btn-sm" href="?r=horarioexamen/createdesdehorario&division='.$division.'&hora='.$hora->id.'&fecha='.$fechats.'&tipo='.$tipo.'&alxtrim='.$anioxtrim->id.'&col='.$col.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                    else*/
                    try {
                        $mesadragable = $item[strtotime($dia2).'-'.$turnocur->id];
                        //$mesadragable = $item['1615172400-1'];
                    } catch (\Throwable $th) {
                        $mesadragable = [];
                    }
                        $array[$turnocur->id][$fechats] = 
                        Sortable::widget([
                            'options' =>[
                                'id' => 'w'.strtotime($dia2).'-'.$turnocur->id,
                            ],
                            //'showHandle'=>true,
                            'connected'=>true,
                            'items'=>$mesadragable,
                            'pluginEvents' => [
                                
                                'sortupdate' => 'function(e) { 
                                    document.getElementById("loadercont").style.display = "block";
                                    var mesa;
                                    var destino;
                                    var origen;
                                    destino = e.detail.destination.container.id; 
                                    origen = e.detail.origin.container.id;
                                    mesa = e.detail.item.id;

                                    $.ajax({
                                        url:"index.php?r=mesaexamen/mover2",
                                        method:"get",
                                        data:{destino:destino, origen:origen, mesa:mesa},
                                        success:function(data){
                                            location.reload();
                                            //$.pjax.reload({container: "#test", async: false});
                                            //alert(data);
                                        },
                                        error:function(jqXhr,asistio,error){
                                            console.log(error);
                                            alert(error);
                                        }
                                    });
                                   

                                    
                                }',
                            ]
                        ]);
                    //$key = array_search($hora->id, array_column($horarios, 'hora'));
                    //$salida .= $key;
                    /*if ($horario->hora == $hora->id && $horario->diasemana == $cd){

                    
                    }*/
                    $ch = $ch + 1;
                }  
            }
            
            $cd = $cd + 1;
        }

        $provider = new ArrayDataProvider([
            'allModels' => $array,
            
        ]);

        return $this->render('paso2', [

            'provider' => $provider,
            'diasgrid' => $diasgrid,
            'listdc' => $listdc,
            'turno' => $turnoX,

        ]);
    }

    protected function getTurnoHorario($mesa){
        $model = $this->findModel($mesa);
        if($model->fecha !=null || $model->hora != null){
            if(strtotime($model->hora)<=strtotime('12:00:00')) {
                return 1;
               } else {
                return 2;
               }
        }else{
            return 0;
        }

    }



    /**
     * Finds the Mesaexamen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mesaexamen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    protected function findModel($id)
    {
        if (($model = Mesaexamen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
