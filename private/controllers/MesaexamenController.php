<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\Actividadxmesa;
use app\models\Agente;
use app\models\Espacio;
use Yii;
use app\models\Mesaexamen;
use app\models\MesaexamenSearch;
use app\models\Tribunal;
use app\models\Turnoexamen;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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
                        'actions' => ['view', 'create', 'update', 'delete'],   
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
    public function actionCreate()
    {
        $model = new Mesaexamen();

        

        $turnosexamen = Turnoexamen::find()->all();
        $espacios = Espacio::find()->all();
        $docentes = Agente::find()->all();
        $actividades = Actividad::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $turnosexamen = Turnoexamen::find()->all();
        $espacios = Espacio::find()->all();
        $docentes = Agente::find()->all();
        $actividades = Actividad::find()->all();

        $actividadesxmesa = Actividadxmesa::find()->where(['mesaexamen' => $id])->all();
        $tribunal = Tribunal::find()->where(['mesaexamen' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $model->save();

            $doc = Yii::$app->request->post()['docentes'];
            $act = Yii::$app->request->post()['actividades'];

            foreach ($actividadesxmesa as $am) {
                $am->delete();
            }
            foreach ($tribunal as $tr) {
                $tr->delete();
            }

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

        return $this->redirect(['index', 'turno' => $model->turnoexamen]);
        }

        $desdeexplode = explode("-",$model->fecha);
        $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
        $model->fecha = $newdatedesde;

        return $this->render('update', [
            'model' => $model,
            'turnosexamen' => $turnosexamen,
            'espacios' => $espacios,
            'docentes' => $docentes,
            'actividades' => $actividades,
            'actividadesxmesa' => $actividadesxmesa,
            'tribunal' => $tribunal,
        ]);
    }

    /**
     * Deletes an existing Mesaexamen model.
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
