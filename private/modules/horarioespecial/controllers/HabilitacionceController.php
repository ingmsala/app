<?php

namespace app\modules\horarioespecial\controllers;

use app\models\Division;
use app\modules\horarioespecial\models\Detallehabilitacion;
use app\modules\horarioespecial\models\Detallemodulo;
use app\modules\horarioespecial\models\Grupodivision;
use Yii;
use app\modules\horarioespecial\models\Habilitacionce;
use app\modules\horarioespecial\models\HabilitacionceSearch;
use app\modules\horarioespecial\models\Horarioclaseespecial;
use app\modules\horarioespecial\models\Moduloclase;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * HabilitacionceController implements the CRUD actions for Habilitacionce model.
 */
class HabilitacionceController extends Controller
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
     * Lists all Habilitacionce models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HabilitacionceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $detallemodulos = Detallemodulo::find()->all();
        $fechas = array_unique(ArrayHelper::map($detallemodulos,'grupodivision0.habilitacionce0.id','grupodivision0.habilitacionce0.fecha'));

        $map = ArrayHelper::map($detallemodulos,'grupodivision0.habilitacionce0.id','grupodivision0.habilitacionce0.fecha');

        
        $events = [];
       
        foreach ($fechas as $key => $fecha) {
            $dm = Detallemodulo::find()->joinWith(['grupodivision0.habilitacionce0'])->where(['habilitacionce.fecha' => $fecha])->all();
            $divisiones = [];
            $titulo = '';
            foreach ($dm as $d) {

                try {
                    $division = $d->grupodivision0->habilitacionce0->division0->nombre;
                if(!in_array($division, $divisiones)){
                    $divisiones[]=$division;
                    $events[] = new \edofre\fullcalendar\models\Event([
                        'id'               => $fecha,
                        'title'            => $division,
                        'start'            => $fecha,
                        'end'              => $fecha,
                        'startEditable'    => false,
                        //'color'            => $color,
                        'url'              => 'index.php?r=horarioespecial/habilitacionce/asignarhorario&fecha='.$fecha.'#'.$d->grupodivision0->habilitacionce,
                        'durationEditable' => false,]);
                }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
                

            }

            
            

        }

        //return var_dump($detallemodulos[]);

        
                
        
              //return var_dump($events);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events,
        ]);
    }

    public function actionHabilitacionpordia()
    {
        $searchModel = new HabilitacionceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        

        $habilitaciones = Habilitacionce::find()->all();

        $detallemodulos = Detallemodulo::find()->all();
        $events = [];

        foreach ($detallemodulos as $detallemodulo) {
            if($detallemodulo->horarioclaseespecial != null){

                $seccion = substr($detallemodulo->grupodivision0->habilitacionce0->division0->nombre, -1);
                if($seccion == "A")
                    $color = '#6AB953';
                elseif($seccion == "B")
                    $color = '#6DDAC4';
                elseif($seccion == "C")
                    $color = '#6DABDA';
                elseif($seccion == "D")
                    $color = '#A56DDA';
                elseif($seccion == "E")
                    $color = '#DA6DAF';
                elseif($seccion == "F")
                    $color = '#DA6D82';
                elseif($seccion == "G")
                    $color = '#DAB96D';
                else
                    $color = '#D1DA6D';
                

                $events[] = new \edofre\fullcalendar\models\Event([
                    'id'               => $detallemodulo->id,
                    'title'            => $detallemodulo->grupodivision0->habilitacionce0->division0->nombre.' - Grupo '.$detallemodulo->grupodivision0->nombre,
                    'start'            => $detallemodulo->grupodivision0->habilitacionce0->fecha.' '.$detallemodulo->horarioclaseespecial0->inicio,
                    'end'              => $detallemodulo->grupodivision0->habilitacionce0->fecha.' '.$detallemodulo->horarioclaseespecial0->fin,
                    'startEditable'    => false,
                    'color'            => $color,
                    'url'              => 'index.php?r=clasevirtual/completoxcurso&division='.$detallemodulo->id.'&vista=docentes&sem='.$detallemodulo->id,
                    'durationEditable' => false,]);
            }
                
        }
              
        
        return $this->render('habilitacionpordia', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events,
        ]);
    }

    /**
     * Displays a single Habilitacionce model.
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
     * Creates a new Habilitacionce model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Habilitacionce();
        $divisiones = Division::find()->where(['<', 'id', 54])->andWhere(['<>', 'id', 47])->all();
        $model->estado = 1;

        if ($model->load(Yii::$app->request->post())) {
            $param = Yii::$app->request->post();
            
            $desdeexplode = explode("/",$param['Habilitacionce']['fecha']);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $grupoparam = $param['grupos'];
            $moduloparam = $param['modulos'];
            foreach ($param['Habilitacionce']['division'] as $division) {

                $test = Habilitacionce::find()->where(['fecha' => $newdatedesde])->andWhere(['division' => $division])->all();
                if($test == null){
                    $model2 = new Habilitacionce();
                    $model2->fecha = $newdatedesde;
                    $model2->estado = 1;
                    $model2->division = $division;
                    $model2->save();

                    for ($i=1; $i <= $grupoparam; $i++) { 
                        # code...
                        $newgrupo = new Grupodivision();
                        $newgrupo->habilitacionce = $model2->id;
                        $newgrupo->nombre = $i;
                        $newgrupo->save();

                        for ($j=1; $j <= $moduloparam ; $j++) { 
                            $model = new Detallemodulo();
                            $model->moduloclase = $j;
                            $model->grupodivision = $newgrupo->id;
                            $model->save();
                        }
                    }
                    
                    
                    
                }
                    
            }

            //return var_dump(Yii::$app->request->post());
            return $this->redirect(['asignarhorario', 'fecha' => $newdatedesde]);
        }

        return $this->render('create', [
            'model' => $model,
            'divisiones' => $divisiones,
        ]);
    }

    public function actionAsignarhorario($fecha){

        //$horario = Horarioclaseespecial::find()->all();
        //$ids = $param = Yii::$app->request->get()['id'];

        $habilitacionesall = Habilitacionce::find()->where(['fecha' => $fecha])->all();

        //var_dump($ids);
        $echodiv = '';
        foreach ($habilitacionesall as $habili) {
            //$habili = Habilitacionce::findOne($id);
            //return var_dump($id);
            $echodiv .= '<div class="col-md-12">';
            $echodiv .=  DetailView::widget([
                'model'=>$habili,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'enableEditMode' => false,
                'panel'=>[
                    'heading'=>$habili->division0->nombre,
                    'headingOptions' => [
                        'template' => '',
                    ],
                    'type'=>DetailView::TYPE_PRIMARY,
                ],
                'attributes'=>[
                    'id',
                    'fecha',
                    'estado',
                    [
                        'label' => 'Horarios',
                        'format' => 'raw',
                        'value' => function() use ($habili) {
                            //return var_dump($model);
                            $grupos = Grupodivision::find()->where(['habilitacionce' => $habili->id])->all();
                            $modulos = Moduloclase::find()->joinWith(['detallemodulos', 'detallemodulos.grupodivision0'])->where(['grupodivision.habilitacionce' => $habili->id])->all();
                            
                            
                            $cd = 0;
                            $array = [];
                            $salida = '';


                            if(count($grupos)==0){
                                $grupomodel = new Grupodivision();
                                $grupomodel->habilitacionce = $habili->id;
                                $grupomodel->nombre = 1;
                                $grupomodel->save();
                                $grupos = Grupodivision::find()->where(['habilitacionce' => $habili->id])->all();
                            }


                            foreach ($grupos as $grupo) {
                                $ch = 0;
                                foreach ($modulos as $modulo) {
                                    # code...
                                    if($cd == 0)
                                        $array[$modulo->id][$cd] = 'Grupo'.'<br /><em>'.$grupo->nombre.'</em>'; 
                                        $array[$modulo->id]['-99'] = '<em>'.$modulo->nombre.'</em>'; 
                                        $array[$modulo->id][$grupo->id] = Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/create&md='.$modulo->id.'&gr='.$grupo->id), 'class' => 'btn btn-success amodalhorariojs']);
                                
                                    $ch = $ch + 1;
                                }
                                $cd = $cd + 1;
                            }
                            //return var_dump($array);
                            $gruposcolumna = [];
                            
                            $gruposcolumna ['-99'] = [
                                
                                'label' => '',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'attribute' => '-99',
                                
                            ];

                            foreach ($grupos as $key => $grupo) {
                                $gruposcolumna[$grupo->id] = 
                                    
                                    [
                                        'label' => 'Grupo '.$grupo->nombre,
                                        'vAlign' => 'middle',
                                        'hAlign' => 'center',
                                        'format' => 'raw',
                                        'attribute' => $grupo->id,
                                        /*'value' => function($model){
                                            return $model['0'];
                                            
                                        }*/
                                    ];
                            }
                            $horarios = Detallemodulo::find()->joinWith(['grupodivision0', 'horarioclaseespecial0'])->where(['grupodivision.habilitacionce' => $habili->id])->orderBy('horarioclaseespecial.inicio')->all();
                            foreach ($horarios as $horariox) {
                                
                                if($horariox->horarioclaseespecial != null){
                                    
                                    $ini = explode(":", $horariox->horarioclaseespecial0->inicio);
                                    $fin = explode(":", $horariox->horarioclaseespecial0->fin);
                                    if($horariox->espacio != null)
                                        $espacio = '<br />'.$horariox->espacio0->nombre;
                                    else
                                        $espacio = ' ';
                                    
                                    if($horariox->detallecatedra != null){
                                        $detallecat = '<br /> '.$horariox->detallecatedra0->catedra0->actividad0->nombre.'<br />('.$horariox->detallecatedra0->docente0->apellido.')';
                                    }else{
                                        $detallecat = ' ';
                                    }
                                    
                                    $array[$horariox->moduloclase][$horariox->grupodivision] .= '<br /><div style="background-color:#dcd9f8;border-style: solid;border-width: 1px;border-radius: 5px;">'.Html::button($ini[0].':'.$ini[1].' a '.$fin[0].':'.$fin[1].$espacio.$detallecat
                                        , ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/update&id='.$horariox->id), 'style' =>'color:#555', 'class' => 'btn btn-link amodalhorariojs']).Html::a('<span class="glyphicon glyphicon-remove"></span>', '?r=horarioespecial/detallemodulo/delete&id='.$horariox->id, 
                                        ['class' => 'deletebuttonhorario',
                                            'data' => [
                                        'confirm' => '¿Está seguro de querer eliminar este elemento?',
                                        'method' => 'post',
                                            ]
                                        ]).'</div>';
                                }
                            }
                            ksort($array);
                            //return var_dump($array);
                            //return var_dump($gruposcolumna);
                            $provider = new ArrayDataProvider([
                                'allModels' => $array,
                                
                            ]);


                           $salida = Html::a('Agregar módulo de horas', Url::to('index.php?r=horarioespecial/detallemodulo/agregarmodulo&md='.($ch+1).'&gr='.$grupo->id), $options = ['class' => 'btn btn-danger', 'data-pjax'=>0]);     
                           $salida .= ' ';
                           $salida .= Html::a('Agregar grupo de división', Url::to('index.php?r=horarioespecial/grupodivision/agregargrupo&ha='.$habili->id.'&gr='.($grupo->nombre + 1)), $options = ['class' => 'btn btn-warning']);     

                           if(count($modulos)==0){
                            return $salida;
                           }
                           $salida .= '<br /><br />';
                           
                            $salida .= GridView::widget([
                                'dataProvider' => $provider,
                                //'filterModel' => $searchModel,
                                'id' => $habili->id,
                                'summary' => false,
                                'hover' => true,
                                'responsiveWrap' => false,
                                'condensed' => true,
                                
                                'columns' => $gruposcolumna,
                            ]);
                            
                            return $salida;
                        }
                    ],
                    
                   
                ]
            ]);
            $echodiv .= '</div>';
        }

        return $this->render('asignarhorario', [
            'echodiv' => $echodiv,
            
        ]);

    }

    /**
     * Updates an existing Habilitacionce model.
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
     * Deletes an existing Habilitacionce model.
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
     * Finds the Habilitacionce model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Habilitacionce the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Habilitacionce::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
