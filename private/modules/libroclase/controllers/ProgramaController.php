<?php

namespace app\modules\libroclase\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\ActividadSearch;
use app\models\Agente;
use app\models\Docentexdepartamento;
use app\models\Plan;
use app\modules\libroclase\models\Detalleunidad;
use Yii;
use app\modules\libroclase\models\Programa;
use app\modules\libroclase\models\ProgramaSearch;
use app\modules\libroclase\models\TemaunidadSearch;
use app\modules\libroclase\models\Unidad;
use kartik\grid\GridView;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class ProgramaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'actividades'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'actividades'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                $depto = Docentexdepartamento::find()->where(['agente' => $persona->id])->count();
                                return (in_array (Yii::$app->user->identity->username, Globales::authttemas) || $depto>0 );
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
     * Lists all Programa models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $searchModel = new ProgramaSearch();
        $dataProvider = $searchModel->poractividad($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actividad' => $id
        ]);
    }

    public function actionActividades()
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $searchModel = new ActividadSearch();
        $dataProvider = $searchModel->porprograma(Yii::$app->request->queryParams);

        return $this->render('actividades', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Programa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $in = 0)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $unidades = Unidad::find()->all();
        $unidadesxprograma = Detalleunidad::find()->where(['programa' => $id])->orderBy('unidad')->all();
        

        $salida = '<div class="panel-group" id="accordion">';
        $i=0;
        foreach ($unidadesxprograma as $du) {
            $i++;

            if($in == $du->id){
                $coll = ' in';
            }else{
                $coll = '';
            }

            $searchModel = new TemaunidadSearch();
            $dataProvider = $searchModel->pordetalleunidad($du->id);

            if($du->nombre == null){
                $uni = $du->unidad0->nombre;
            }else{
                $uni = $du->unidad0->nombre.': '.$du->nombre;
            }

            if($dataProvider->getTotalCount()>0){
                $panel = 'default';
            }else{
                $panel = 'danger';
            }

            $salida .= '<div class="panel panel-'.$panel.'">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$du->id.'">
                '.$uni.'</a>'.Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=libroclase/detalleunidad/update&id='.$du->id), 'class' => 'btn btn-main btn-link amodalnuevodetalleunidad']).'
              </h4>
            </div>
            <div id="collapse'.$du->id.'" class="panel-collapse collapse'.$coll.'">
              <br /><div class="pull-right">'.
              Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar tema', ['value' => Url::to('index.php?r=libroclase/temaunidad/create&detalleunidad='.$du->id), 'class' => 'btn btn-main btn-primary amodalagregartema']).'</div><div class="clearfix"></div><br />'.
              GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'condensed' => true,
                //'pjax'=>true,
                'responsiveWrap' => false,
                'condensed' => true,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
        
                    'descripcion',
                    //'prioridad',
        
                    [
                        //'class' => 'kartik\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:25%'],
                        //'template' => '{viewdetcat}{deletedetcat}',
                        'format' => 'raw',
                        
                        'value' => 
                            function($model){
                                $salida = Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=libroclase/temaunidad/update&id='.$model['id']), 'class' => 'btn btn-main btn-info amodalagregartema']);
                            
                                $salida .= ' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=libroclase/temaunidad/delete&id='.$model['id'], 
                                    [
                                    'class' => 'btn btn-main btn-danger',    
                                    'data' => [
                                    'confirm' => 'Está seguro de querer eliminar este elemento?',
                                    'method' => 'post',
                                     ]
                                    ]);

                                    $salida .= ' '.Html::button('<span class="glyphicon glyphicon-triangle-top"></span>', ['value' => Url::to('index.php?r=libroclase/temaunidad/cambiarprioridad&up=1&id='.$model['id']), 'class' => 'btn btn-main btn-success bajarprioridad']);
                                    $salida .= ' '.Html::button('<span class="glyphicon glyphicon-triangle-bottom"></span>', ['value' => Url::to('index.php?r=libroclase/temaunidad/cambiarprioridad&up=0&id='.$model['id']), 'class' => 'btn btn-main btn-success bajarprioridad']);
                

                                return $salida;
                            }
                        
        
                    ],
                ],
            ])
              .'
            </div>
          </div>';
        }
        $salida .= '</div>';
        

        return $this->render('view', [
            'model' => $this->findModel($id),
            'salida' => $salida,
        ]);
    }

    /**
     * Creates a new Programa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ac)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $model = new Programa();
        $actividad = Actividad::find()->where(['id' => $ac])->one();
        $model->plan = $actividad->plan;
        $model->actividad = $actividad->id;
        $model->vigencia = 1;
        $planes = Plan::find()->where(['id' => $actividad->plan])->all();
        $actividades = Actividad::find()->where(['id' => $ac])->orderBy('nombre')->all();
        $vigencias = [1=>'Vigente', 2=>'Inactivo'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'planes' => $planes,
            'actividades' => $actividades,
            'vigencias' => $vigencias,
        ]);
    }

    /**
     * Updates an existing Programa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $model = $this->findModel($id);
        $actividad = Actividad::find()->where(['id' => $model->actividad])->one();
        $planes = Plan::find()->where(['id' => $actividad->plan])->all();
        $actividades = Actividad::find()->where(['id' => $model->actividad])->orderBy('nombre')->all();
        $vigencias = [1=>'Vigente', 2=>'Inactivo'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'planes' => $planes,
            'actividades' => $actividades,
            'vigencias' => $vigencias,
        ]);
    }

    /**
     * Deletes an existing Programa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $actividad = $model->actividad;
        $model->delete();

        return $this->redirect(['index', 'id' => $actividad]);
    }

    /**
     * Finds the Programa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
