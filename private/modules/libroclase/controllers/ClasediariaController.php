<?php

namespace app\modules\libroclase\controllers;

use app\config\Globales;
use app\models\Detallecatedra;
use app\models\Division;
use app\models\Agente;
use app\models\Catedra;
use app\models\Detalleparte;
use app\models\Hora;
use app\models\Horario;
use app\models\Nombramiento;
use app\models\Parametros;
use app\models\Parte;
use app\models\Preceptoria;
use app\models\Rolexuser;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\horariogenerico\models\Horariogeneric;
use Yii;
use app\modules\libroclase\models\Clasediaria;
use app\modules\libroclase\models\ClasediariaSearch;
use app\modules\libroclase\models\Detalleunidad;
use app\modules\libroclase\models\Horaxclase;
use app\modules\libroclase\models\Modalidadclase;
use app\modules\libroclase\models\Temaxclase;
use app\modules\libroclase\models\Tipocurricula;
use app\modules\libroclase\models\Tipodesarrollo;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClasediariaController implements the CRUD actions for Clasediaria model.
 */
class ClasediariaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'gethorashorario', 'catedra'],
                'rules' => [
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['catedra', 'create', 'gethorashorario'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if (in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE])){
                                    $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            
                                    $dcs = Detallecatedra::find()
                                        ->joinWith(['catedra0', 'catedra0.division0'])
                                        ->where(['detallecatedra.agente' => $doc->id])
                                        ->andWhere(['detallecatedra.revista' => 6])
                                        ->andWhere(['detallecatedra.aniolectivo' => 3])
                                        ->andWhere(['catedra.id' => Yii::$app->request->queryParams['cat']])
                                        ->all();
                                    if(count($dcs)>0)
                                        return true;
                                    else
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
                                if (in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE])){
                                    $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $clase = $this->findModel(Yii::$app->request->queryParams['id']);
            
                                    $dcs = Detallecatedra::find()
                                        ->joinWith(['catedra0', 'catedra0.division0'])
                                        ->where(['detallecatedra.agente' => $doc->id])
                                        ->andWhere(['detallecatedra.revista' => 6])
                                        ->andWhere(['detallecatedra.aniolectivo' => 3])
                                        ->andWhere(['catedra.id' => $clase->catedra])
                                        ->all();
                                        
                                    if(count($dcs)>0)
                                        return true;
                                    else
                                        return false;

                                }
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'view', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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

    public function actionGethorashorario($cat, $fecha){
        return $this->gethorashorario($cat, $fecha, 1);
    }
    public function gethorashorario($cat, $fecha, $aj){

        $fechastr = strtotime($fecha);
        $diasemana = date('w', $fechastr)+1;

        $originalOgenerico = Parametros::findOne(5)->estado;
        $aniolectivo = Aniolectivo::find()->where(['nombre' => date('Y')])->one();
        

        if($originalOgenerico == 1)
            $horarios = Horario::find()
                    ->where(['horario.catedra' => $cat])
                    ->andWhere(['horario.diasemana' => $diasemana])
                    ->andWhere(['horario.aniolectivo' => $aniolectivo->id])
                    ->all();
        else
            $horarios = Horariogeneric::find()
                        ->joinWith(['semana0'])
                        ->where(['catedra' => $cat])
                        ->andWhere(['fecha' => $fecha])
                        ->andWhere(['horariogeneric.aniolectivo' => $aniolectivo->id])
                        ->andWhere(['semana.publicada' => 1])
                        ->all();
        
        $horas = [];
        $horasid = [];
        $echo = '';
        if(count($horarios)>0){
            $echo .= '<optgroup label="Horas Sugeridas">';
            foreach ($horarios as $horario) {
                if($originalOgenerico == 1){
                    $horaclase_id = $horario->hora;
                    $horaclase_nombre = $horario->hora0->nombre;
                }
                    
                else{
                    $horaclase_id = $horario->horareloj0->hora;
                    $horaclase_nombre = $horario->horareloj0->hora0->nombre;
                }
                $horasid[] = $horaclase_id;
                $horas ['Horas Sugeridas'][$horaclase_id] = $horaclase_nombre;
                $echo .= "<option value='".$horaclase_id."'>".$horaclase_nombre."</option>";
            }
            $echo .= '</optgroup>';
        }

        $horasbd = Hora::find()->where(['not in', 'id', $horasid])->all();
        if(count($horasbd)>0){
            $echo .= '<optgroup label="Otras horas">';
            foreach ($horasbd as $horabd) {
                $horas ['Otras horas'][$horabd->id] = $horabd->nombre;
                $echo .= "<option value='".$horabd->id."'>".$horabd->nombre."</option>";
            }
            $echo .= '</optgroup>';
        }
        if($aj==1)
            return $echo;
        else
            return $horas;
    }

    /**
     * Lists all Clasediaria models.
     * @return mixed
     */
    public function actionCatedra($cat, $al = 3)
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $searchModel = new ClasediariaSearch();
        $catedra = Catedra::findOne($cat);
        $dataProvider = $searchModel->porcatedra($cat, $al);
        
        //return var_dump($this->getFaltacargar($cat));
        $horasenfalta = $this->getFaltacargar($cat, $al);
        //return var_dump($horasenfalta);
        if(count($horasenfalta)>0){
            $provider = new ArrayDataProvider([
                'allModels' => $horasenfalta,
            ]);
            $horasfaltantes = $this->renderPartial('horasfaltantes', [
                'dataProvider' => $provider,
                'catedra' => $cat,
            ]);
        }else
            $horasfaltantes = '';

        $cant = Horaxclase::find()
                    ->joinWith(['clasediaria0'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['clasediaria.aniolectivo' => $al])
                    ->count();
        
        return $this->render('catedra', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'catedra' => $catedra,
            'horasfaltantes' => $horasfaltantes,
            'cant' => $cant,
        ]);
    }

    public function getFaltacargar($cat, $al){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $catedra = Catedra::findOne($cat);
        $preceptoria = $catedra->division0->preceptoria;

       
        $partes = Parte::find()
                    ->where(['<', 'tipoparte', 3])
                    ->andWhere(['=', 'YEAR(fecha)', date('Y')])
                    ->andWhere(['preceptoria' => $preceptoria])
                    ->all();
        //$agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $agente = $catedra->getDocentehorarioal0($al);
        $agente = $agente['agenteid'];
        
        $horarios = [];
        $originalOgenerico = Parametros::findOne(5)->estado;
        $aniolectivo = Aniolectivo::find()->where(['nombre' => date('Y')])->one();

        foreach ($partes as $parte) {

            $fecha = strtotime($parte->fecha);
            $diasemana = date('w', $fecha)+1;
            

            if($originalOgenerico == 1)
                $horario = Horario::find()
                        ->where(['horario.catedra' => $cat])
                        ->andWhere(['horario.diasemana' => $diasemana])
                        ->andWhere(['horario.aniolectivo' => $aniolectivo->id])
                        ->all();
            else
                $horario = Horariogeneric::find()
                            ->joinWith(['semana0'])
                            ->where(['catedra' => $cat])
                            ->andWhere(['fecha' => $parte->fecha])
                            ->andWhere(['horariogeneric.aniolectivo' => $aniolectivo->id])
                            ->andWhere(['semana.publicada' => 1])
                            ->all();

            if(count($horario)>0){
                $faltas = Detalleparte::find()
                    ->where(['division' => $catedra->division])
                    ->andWhere(['parte' => $parte])
                    ->andWhere(['agente' => $agente])
                    ->andWhere(['falta' => 1])
                    ->all();

                if(count($faltas)==0)
                    $horarios[$parte->fecha] = $parte->fecha;
            }
        }
        //return $horarios;
        $horariosok = [];
        foreach ($horarios as $value) {
            $horario2 = Clasediaria::find()
                ->where(['catedra' => $cat])
                ->andWhere(['=', 'fecha', $value])
                ->all();
            if(count($horario2)==0)
                $horariosok[$value]['fecha'] = $value;
        }

        
        

        

        /*$clases = Clasediaria::find()
                    ->where(['catedra' => $cat])
                    ->andWhere(['in', 'fecha', $partes])
                    ->all();*/
        
        return $horariosok;
        


    }

    public function actionIndex()
    {
        $p = Parametros::findOne(6)->estado;
        if($p == 0){
            Yii::$app->session->setFlash('warning', "La sección del libro de temas no está habilitada");
            return $this->goHome();
        }

        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();
        
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
            
            $echodiv = '';
            foreach ($divisiones as $division) {
                    $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                    $echodiv .= '<center><div>';
                    $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/clasediaria/division&d='.$division->id.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                    $echodiv .= '</div></center>';
                    $echodiv .= '</div>';
            }
            return $this->render('menuxdivision', [
                'echodiv' => $echodiv,
            ]);
        }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){

            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $nom = Nombramiento::find()
                        ->where(['agente' => $doc->id])
                        ->andWhere(['<=', 'division', 53])
                        //->andWhere(['is not', 'division', 53])
                        ->all();
            $divisiones = [];
            foreach ($nom as $n) {
                $divisiones [] = $n->division0;
            }
            $echodiv = '';
            foreach ($divisiones as $division) {
                    $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                    $echodiv .= '<center><div>';
                    $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/clasediaria/division&d='.$division->id.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                    $echodiv .= '</div></center>';
                    $echodiv .= '</div>';
            }
            return $this->render('menuxdivision', [
                'echodiv' => $echodiv,
            ]);

        }elseif(Yii::$app->user->identity->role == Globales::US_AGENTE){
            //$this->layout = 'mainpersonal';
            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            
            $dcs = Detallecatedra::find()
                ->joinWith(['catedra0', 'catedra0.division0'])
                ->where(['detallecatedra.agente' => $doc->id])
                ->andWhere(['detallecatedra.revista' => 6])
                ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo])
                ->orderBy('division.id')
                ->all();

            $array = [];

            foreach ($dcs as $dc) {
                $array [] = $dc->catedra0;
            }

            $divisiones = $array;
            $echodiv = '';
            foreach ($divisiones as $catedra) {
                //return var_dump($catedra);
                    $echodiv .= '<div class="pull-left" >';
                    $echodiv .= '<center><div  style="margin:10px;">';
                    $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/clasediaria/catedra&cat='.$catedra['id'].'" role="button" >'.$catedra['division0']['nombre'].'<br><span style="font-size:0.5em;" class="label label-default">'.$catedra['actividad0']['nombre'].'</span></a>';
                    $echodiv .= '</div></center>';
                    $echodiv .= '</div>';
            }
            return $this->render('menuxdivision', [
                'echodiv' => $echodiv,
            ]);
        
        }else{
            $divisiones = Division::find()
                                    ->where(['in', 'preceptoria', [1,2,3,4,5,6]])
                                    ->orderBy('id')
                                    ->all();
            
            $echodiv = '';
            foreach ($divisiones as $division) {
                    $echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
                    $echodiv .= '<center><div>';
                    $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/clasediaria/division&d='.$division->id.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                    $echodiv .= '</div></center>';
                    $echodiv .= '</div>';
            }
            return $this->render('menuxdivision', [
                'echodiv' => $echodiv,
            ]);
        }
        
        
    }

    /**
     * Displays a single Clasediaria model.
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
     * Creates a new Clasediaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cat, $fecha=null)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $model = new Clasediaria();
        
        $modelhxc = new Horaxclase();

        $catedra = Catedra::findOne($cat);
        $model->catedra = $catedra->id;
        if($fecha == null){
            $model->fecha = date('d/m/Y');
            $fechafind = date('Y-m-d');
        }
        else{
            $model->fecha = Yii::$app->formatter->asDate($fecha, 'dd/MM/yyyy');
            $fechafind = $fecha;
        }
        
        $modelidadesclase = Modalidadclase::find()->all();
        $tiposcurricula = Tipocurricula::find()->all();
        $horas = Hora::find()->all();
        

        $horasaj = $this->gethorashorario($cat, Yii::$app->formatter->asDate($fechafind, 'yyyy-MM-dd'), 2);
        
        $unidades = Detalleunidad::find()
                                ->joinWith(['unidad0', 'programa0'])
                                ->where(['programa.actividad' => $catedra->actividad])
                                ->andWhere(['programa.vigencia' => 1])
                                ->orderBy('unidad.id')
                                ->all();
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $model->agente = $agente->id;
        $model->tipocurricula = 1;

        if ($model->load(Yii::$app->request->post()) && $modelhxc->load(Yii::$app->request->post())) {
            /*if($model->tipocurricula == 2){
                $model->scenario = Clasediaria::SCENARIO_EXTRACURRICULAR;
                return $model->validate();
            }*/
            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            $model->aniolectivo = 3;
            
            $model->fechacarga = date('Y-m-d H:i');

            
            
            $param = Yii::$app->request->post();
            try {
                $tipodes = $param['tipodes'];
            } catch (\Throwable $th) {
                $tipodes = [];
            }

            $ok = false;
            try {
                if($model->tipocurricula == 1)
                    $valtemas = $param['valtemas'];
                $model->save();
                $ok = true;
            } catch (\Throwable $th) {
                $valtemas = [];
                if($model->tipocurricula == 1)
                    Yii::$app->session->setFlash('danger', "Debe cargar un tema");
            }

            
            if($ok){
                foreach ($modelhxc['hora'] as $horax) {
                    $newhxc = new Horaxclase();
                    $newhxc->clasediaria = $model->id;
                    $newhxc->hora = $horax;
                    $newhxc->save();
                }
            }
            

            if($model->tipocurricula == 1){
                $ok = false;
                foreach ($valtemas as $key => $tema) {
                    $newTemaxClase = new Temaxclase();
                    $newTemaxClase->clasediaria = $model->id;
                    try {
                        $newTemaxClase->tipodesarrollo = $tipodes[$tema];
                    } catch (\Throwable $th) {
                        $newTemaxClase->tipodesarrollo = 1;
                    }
                    $newTemaxClase->temaunidad = $tema;
                    $newTemaxClase->save();
                    $ok = true;
                    
                    
                }
            }
            if($ok)
                return $this->redirect(['catedra', 'cat' => $model->catedra]);
            else
                $fechaexplode = explode("-",$model->fecha);
                $newdatefecha = date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0]));
                $model->fecha = $newdatefecha;


            
            
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelhxc' => $modelhxc,
            'modelidadesclase' => $modelidadesclase,
            'unidades' => $unidades,
            'horas' => $horas,
            'horasaj' => $horasaj,
            'catedra' => $catedra,
            'tiposcurricula' => $tiposcurricula,

        ]);
    }

    /**
     * Updates an existing Clasediaria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);
        $model = $this->findModel($id);
        $modelhxc = new Horaxclase();

        $catedra = Catedra::findOne($model->catedra);
        
        $modelidadesclase = Modalidadclase::find()->all();
        $horas = Hora::find()->all();
        $unidades = Detalleunidad::find()
                                ->joinWith(['unidad0', 'programa0'])
                                ->where(['programa.actividad' => $catedra->actividad])
                                ->andWhere(['programa.vigencia' => 1])
                                ->orderBy('unidad.id')
                                ->all();

        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $model->agente = $agente->id;

        if ($model->load(Yii::$app->request->post()) && $modelhxc->load(Yii::$app->request->post())) {
            
            $explode = explode("/",$model->fecha);
            $newdate = date("Y-m-d", mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
            $model->fecha = $newdate;
            $model->aniolectivo = 3;
            
            $model->fechacarga = date('Y-m-d H:i');

            
            
            $param = Yii::$app->request->post();
            try {
                $tipodes = $param['tipodes'];
            } catch (\Throwable $th) {
                $tipodes = [];
            }
            $ok = false;
            try {
                $valtemas = $param['valtemas'];
                $model->save();
                $ok = true;
            } catch (\Throwable $th) {
                $valtemas = [];
                Yii::$app->session->setFlash('danger', "Debe cargar un tema");
            }

            
            if($ok){
                foreach ($modelhxc['hora'] as $horax) {
                    $newhxc = new Horaxclase();
                    $newhxc->clasediaria = $model->id;
                    $newhxc->hora = $horax;
                    $newhxc->save();
                }
            }
            

           
            $ok = false;
            foreach ($valtemas as $key => $tema) {
                $newTemaxClase = new Temaxclase();
                $newTemaxClase->clasediaria = $model->id;
                try {
                    $newTemaxClase->tipodesarrollo = $tipodes[$tema];
                } catch (\Throwable $th) {
                    $newTemaxClase->tipodesarrollo = 1;
                }
                $newTemaxClase->temaunidad = $tema;
                $newTemaxClase->save();
                $ok = true;
                
                
            }
            if($ok)
                return $this->redirect(['catedra', 'cat' => $model->catedra]);
            else
                $fechaexplode = explode("-",$model->fecha);
                $newdatefecha = date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0]));
                $model->fecha = $newdatefecha;


        }

        $desdeexplode = explode("-",$model->fecha);
        $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
        $model->fecha = $newdatedesde;

        return $this->render('update', [
            'model' => $model,
            'modelhxc' => $modelhxc,
            'modelidadesclase' => $modelidadesclase,
            'unidades' => $unidades,
            'horas' => $horas,
            'catedra' => $catedra,

        ]);
            
            
    }

    /**
     * Deletes an existing Clasediaria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $catedra = $model->catedra;
        $model->delete();
        Yii::$app->session->setFlash('success', 'Se eliminó correctamente la clase del libro de temas.');
        return $this->redirect(['catedra', 'cat' => $catedra]);
        
    }

    /**
     * Finds the Clasediaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clasediaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clasediaria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
