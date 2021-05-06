<?php

use app\models\Catedra;
use app\models\Diasemana;
use app\models\Hora;
use app\modules\horariogenerico\models\Horareloj;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log de '.$title;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['/logs']];
$this->params['breadcrumbs'][] = $this->title;

$listdivisiones=ArrayHelper::map($divisiones,'nombre','nombre');
?>
<div class="horario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => "Fecha operación",
                'attribute' => '0',
                'value' => function($model){
                    return $model['0'];
                }
            ],
            [
                'label' => "Hora operacion",
                'attribute' => '1',
                'value' => function($model){
                    return $model['1'];
                }
            ],
            [
                'label' => "Usuario",
                'value' => function($model){
                    return $model['3']->username;
                }
            ],
            [
                'label' => "Operación",
                'format' => "raw",
                'hAlign' => 'center',
                'value' => function($model){
                    if($model['3']->action == "createdesdehorario"){
                        return '<span class="glyphicon glyphicon-stop" style="color:green" aria-hidden="true"></span>';
                    }elseif($model['3']->action == "updatedesdehorario"){
                        return '<span class="glyphicon glyphicon-stop" style="color:orange" aria-hidden="true"></span>';
                    }else{
                        return '<span class="glyphicon glyphicon-stop" style="color:red" aria-hidden="true"></span>';
                    }
                }
            ],
            [
                'label' => "Fecha",
                'value' => function($model){
                    try {
                        return $model['3']->modelnew->fecha;
                        
                    } catch (\Throwable $th) {
                        
                    }
                    
                }
            ],
            [
                'label' => "Dia",
                'value' => function($model){
                    if(isset($model['3']->modelnew->diasemana)){
                        $dia = Diasemana::findOne($model['3']->modelnew->diasemana);
                        return $dia->nombre;
                    }else{
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($model['3']->modelnew->fecha, 'dd/MM/yyyy');
                        
                    }
                    
                }
            ],
            [
                'label' => "Hora",
                'value' => function($model){
                    try {
                        $hora = Hora::findOne($model['3']->modelnew->hora);
                        return $hora->nombre;
                    } catch (\Throwable $th) {
                        return Horareloj::findOne($model['3']->modelnew->horareloj)->hora0->nombre;
                    }
                    
                }
            ],
            [
                'label' => "División",
                'format' => "raw",
                'filter' => Html::dropDownList('filteremail', $selection = $searchModel['ee'], $listdivisiones, 
                            ['class'=>"form-control", 'value'=>$searchModel['ee'], 'prompt'=> 'Seleccionar...']),

                'value' => function($model){
                    if(isset($model['3']->modelnew->catedra)){
                        $cat = Catedra::findOne($model['3']->modelnew->catedra);
                        try {
                            foreach ($cat->detallecatedras as $dc) {
                                if ($dc->revista == 6 && $dc->aniolectivo ==3){
                                    $doc = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);
                                    break;
                                }
                            }
    
                            return $cat->division0->nombre;
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        
                    }
                    return "";
                        
                }
            ],
            [
                'label' => "Cátedra Anterior",
                'format' => "raw",

                'value' => function($model){
                    if(isset($model['3']->modelold->catedra)){
                        $cat = Catedra::findOne($model['3']->modelold->catedra);
                        $doc= '';
                        try {
                            foreach ($cat->detallecatedras as $dc) {
                                if ($dc->revista == 6 && $dc->aniolectivo ==3){
                                    $doc = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);
                                    break;
                                }
                            }
    
                            return $cat->actividad0->nombre.' <span class="badge">'.$doc.'</span>';
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        
                    }
                    return "";
                        
                }
            ],
            [
                'label' => "Cátedra Actual",
                'format' => "raw",
                'filter' => '<input class="form-control" name="filtermateria" value="'. $searchModel['materia'] .'" type="text">' ,
                'value' => function($model){
                    $cat = Catedra::findOne($model['3']->modelnew->catedra);
                    $doc= '';
                    try {
                        foreach ($cat->detallecatedras as $dc) {
                            if ($dc->revista == 6 && $dc->aniolectivo ==3){
                                $doc = $dc->agente0->apellido.', '.substr($dc->agente0->nombre,1,1);
                                break;
                            }
                        }
                        return $cat->actividad0->nombre.' <span class="badge">'.$doc.'</span>';
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    
                    
                }
            ],
            
            //'3.modelnew.catedra',
            

            
        ],
    ]); ?>
</div>
