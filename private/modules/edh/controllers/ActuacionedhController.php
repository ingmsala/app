<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\Detallecatedra;
use app\models\Nombramiento;
use app\models\Rolexuser;
use app\modules\curriculares\models\Tutor;
use app\modules\edh\models\Actorxactuacion;
use Yii;
use app\modules\edh\models\Actuacionedh;
use app\modules\edh\models\ActuacionedhSearch;
use app\modules\edh\models\Areainformaact;
use app\modules\edh\models\Areasolicitud;
use app\modules\edh\models\Caso;
use app\modules\edh\models\Lugaractuacion;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ActuacionedhController implements the CRUD actions for Actuacionedh model.
 */
class ActuacionedhController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_REGENCIA, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = Caso::findOne(Yii::$app->request->queryParams['id']);

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                

                                $jefe = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

                                if ($caso->jefe == $jefe->id)
                                     return true;
                            }

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){

                                $prece = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                        
                                if ($caso->preceptor == $prece->id)
                                     return true;
                            
                            }

                            return false;
                        }

                    ],
                    [
                        'actions' => ['create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_REGENCIA, Globales::US_VICEACAD])){
                                    return true;
                                }
                            }catch(\Exception $exception){
                                return false;
                            }

                            $caso = Caso::findOne(Yii::$app->request->queryParams['caso']);

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                

                                $jefe = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

                                if ($caso->jefe == $jefe->id)
                                     return true;
                            }

                            if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){

                                $prece = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                        
                                if ($caso->preceptor == $prece->id)
                                     return true;
                            
                            }

                            return false;
                        }

                    ],
                    [
                        'actions' => ['update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $actuacion = Actuacionedh::findOne(Yii::$app->request->queryParams['id']);
                            $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                            if($actuacion->agente == $agente->id){
                                try{
                                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION, Globales::US_REGENCIA, Globales::US_VICEACAD])){
                                        return true;
                                    }
                                }catch(\Exception $exception){
                                    return false;
                                }
                                $actuacion = Actuacionedh::findOne(Yii::$app->request->queryParams['id']);
                                $caso = Caso::findOne($actuacion->caso);
    
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])){
                                    if ($caso->jefe == $agente->id)
                                        return true;
                                }
    
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){
                                    if ($caso->preceptor == $agente->id)
                                         return true;
                                }
    
                                return false;
                            }else{
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
     * Lists all Actuacionedh models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $searchModel = new ActuacionedhSearch();
        $dataProvider = $searchModel->porCaso($id);
        $model = Caso::findOne($id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Actuacionedh model.
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
     * Creates a new Actuacionedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($caso)
    {
        
        $model = new Actuacionedh();
        $modelActores = new Actorxactuacion();
        $modelAreainf = new Areainformaact();
        $model->caso = $caso;
        $casoX = Caso::findOne($caso);
        if($casoX->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        $lugaresactuacion = Lugaractuacion::find()->all();
        $areas = Areasolicitud::find()->all();

        $actores = $this->getActores($caso);
        


        if ($model->load(Yii::$app->request->post()) && $modelActores->load(Yii::$app->request->post()) && $modelAreainf->load(Yii::$app->request->post())) {

            $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $model->agente = $agente->id; 
            $model->tipoactuacion = 1;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model->fechacreate = date('Y-m-d H:i');

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->log = 1;

            //return var_dump($modelAreainf);
            $model->save();

            try{
                foreach ($modelActores['persona'] as $persona) {
                    $modelActoresX = new Actorxactuacion();
                    $modelActoresX->persona = $persona;
                    $modelActoresX->actuacion = $model->id;
                    $modelActoresX->save();
                }
            }catch(\Throwable $th){

            }
            
            try{
                foreach ($modelAreainf['area'] as $area) {
                    $modelAreainfX = new Areainformaact();
                    $modelAreainfX->area = $area;
                    $modelAreainfX->actuacion = $model->id;
                    $modelAreainfX->save();
                }
            }catch(\Throwable $th){

            }

            Yii::$app->session->setFlash('success', "Se creó correctamente la actuación");
            return $this->redirect(['index', 'id' => $model->caso]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'lugaresactuacion' => $lugaresactuacion,
            'areas' => $areas,
            'actores' => $actores,
            'modelActores' => $modelActores,
            'modelAreainf' => $modelAreainf,
            
        ]);
    }

    public function getActores($caso){
        $caso = Caso::findOne($caso);
        $tutores = Tutor::find()
                ->where(['alumno' => $caso->matricula0->alumno])
                ->all();

        $docentes_curso = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->where(['catedra.division' => $caso->matricula0->division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $caso->matricula0->aniolectivo])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();

        $items = [];

        $nombramientos = Nombramiento::find()
                            ->joinWith(['agente0'])
                            ->where(['in', 'cargo', [225,207,242]])
                            ->all();

        $preceptorcurso = Agente::find()
            ->where(['id' => $caso->preceptor])
            ->one();

        $jefe = Agente::find()
            ->where(['id' => $caso->jefe])
            ->one();
        

        foreach ($docentes_curso as $detcat) {
            $items ['Docentes de '.$detcat->catedra0->division0->nombre][$detcat->agente0->documento] = $detcat->catedra0->division0->nombre.' - '.$detcat->agente0->apellido.', '.$detcat->agente0->nombre.' ('.$detcat->catedra0->actividad0->nombre.')';
        }

        try {
            $items ['Preceptor/a del curso'][$preceptorcurso->documento] = $caso->matricula0->division0->nombre.' - '.$preceptorcurso->apellido.', '.$preceptorcurso->nombre.' (Preceptor/a)';
            $precedoc = $preceptorcurso->documento;
        } catch (\Throwable $th) {
            $precedoc = null;
        }
        
        
        try {
            $items ['Jefe/a de piso del curso'][$jefe->documento] = $jefe->apellido.', '.$jefe->nombre.' (Jefe de '.$caso->matricula0->division0->preceptoria0->descripcion.')';
            $jefedoc = $jefe->documento;
        } catch (\Throwable $th) {
            $jefedoc = null;
        }

        $items ['Estudiante'][$caso->matricula0->alumno0->documento] = $caso->matricula0->alumno0->apellido.', '.$caso->matricula0->alumno0->nombre.' (Estudiante)';
        
            foreach ($tutores as $tutor) {
            $items ['Tutores'][$tutor->documento] = $tutor->apellido.', '.$tutor->nombre.' (Tutor - '.$tutor->parentesco.')';
        }
        

        foreach ($nombramientos as $nom) {
            $items ['Equipo de Salud'][$nom->agente0->documento] = $nom->agente0->apellido.', '.$nom->agente0->nombre.' ('.$nom->cargo0->nombre.')';
        }

        //return var_dump(array_column(array_column($docentes_curso, 'agente0'), 'documento'));
        $agentes = Agente::find()
                ->where(['not in', 'documento', array_column(array_column($docentes_curso, 'agente0'), 'documento')])
                ->andWhere(['not in', 'documento', array_column(array_column($nombramientos, 'agente0'), 'documento')])
                ->andWhere(['<>', 'documento', $jefedoc])
                ->andWhere(['<>', 'documento', $precedoc])
                ->orderBy('apellido, nombre')->all();

        foreach ($agentes as $agente) {
            $items ['Otros docentes'][$agente->documento] = $agente->apellido.', '.$agente->nombre;
        }

        
            

        return $items;
    }

    /**
     * Updates an existing Actuacionedh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->caso0->estadocaso == 2){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>';
        }
        if($model->tipoactuacion != 1){
            return '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar una actuación autogenerada por el sistema.';
        }

        $modelActores = new Actorxactuacion();
        $modelAreainf = new Areainformaact();

        $modelActoresaux = Actorxactuacion::find()->where(['actuacion' => $model->id])->all();
        $modelAreainfaux = Areainformaact::find()->where(['actuacion' => $model->id])->all();

        $modelActores->persona = array_column($modelActoresaux, 'persona');
        $modelAreainf->area = array_column($modelAreainfaux, 'area');

       
        $lugaresactuacion = Lugaractuacion::find()->all();
        $areas = Areasolicitud::find()->all();

        $actores = $this->getActores($model->caso);
       

        if ($model->load(Yii::$app->request->post()) && $modelActores->load(Yii::$app->request->post()) && $modelAreainf->load(Yii::$app->request->post())) {
            
            $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $model->agente = $agente->id;

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $model->fechacreate = date('Y-m-d H:i');

            $model->save();

            foreach ($model->actorxactuacions as $axa) {
                $axa->delete();
            }
            foreach ($model->areainformaacts as $aia) {
                $aia->delete();
            }   
            try{
                foreach ($modelActores['persona'] as $persona) {
                    $modelActoresX = new Actorxactuacion();
                    $modelActoresX->persona = $persona;
                    $modelActoresX->actuacion = $model->id;
                    $modelActoresX->save();
                }
            }catch(\Throwable $th){

            }
            
            try{
                foreach ($modelAreainf['area'] as $area) {
                    $modelAreainfX = new Areainformaact();
                    $modelAreainfX->area = $area;
                    $modelAreainfX->actuacion = $model->id;
                    $modelAreainfX->save();
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            Yii::$app->session->setFlash('success', "Se modificó correctamente la actuación");
            return $this->redirect(['index', 'id' => $model->caso]);
        }

       

        $fechaexplode = explode("-",$model->fecha);
        $newdatefecha = date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0]));
        $model->fecha = $newdatefecha;

        return $this->renderAjax('update', [
            'model' => $model,
            'lugaresactuacion' => $lugaresactuacion,
            'areas' => $areas,
            'actores' => $actores,
            'modelActores' => $modelActores,
            'modelAreainf' => $modelAreainf,
        ]);
    }

    /**
     * Deletes an existing Actuacionedh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $actuacion = $this->findModel($id);
        $caso = $actuacion->caso;
        if($actuacion->caso0->estadocaso == 2){
            Yii::$app->session->setFlash('danger', '<div class="glyphicon glyphicon-info-sign" style="color:#a94442;"></div> No puede modificar un caso en estado <b>Cerrado</b>');
            return $this->redirect(['index', 'id' => $caso]);
        }
        
        $actuacion->delete();

        Yii::$app->session->setFlash('success', "Se eliminó correctamente la actuación");

        return $this->redirect(['index', 'id' => $caso]);

    }

    /**
     * Finds the Actuacionedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actuacionedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actuacionedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
