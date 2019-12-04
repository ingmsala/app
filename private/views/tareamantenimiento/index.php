<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TareamantenimientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($historial) ? 'Historial de Tareas de mantenimiento' : 'Tareas de mantenimiento';

?>
<div class="tareamantenimiento-index">

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'toolbar'=>[
            Html::a('Nueva tarea', ['create'], ['class' => 'btn btn-success']),
            ['content' =>  ($historial) ? Html::a('Activos', ['index'], ['class' => 'btn btn-default']) : Html::a('Historial', ['historial'], ['class' => 'btn btn-default'])

            ],
            '{export}',

            
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Descripción',
                'vAlign' => 'middle',
                //'hAlign' => 'center',
                'value' => function($model){
                     if($model->estadotarea != 1 || Yii::$app->user->identity->role != 17)
                        return $model->descripcion;
                    return '';
                }
            ],
            
            [
                'label' => 'Responsable',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    try {
                        return $model->responsable0->apellido.', '.$model->responsable0->nombre;
                    } catch (Exception $e) {
                        return 'Area de mantenimiento';
                    }
                    
                }
            ],

            [
                'label' => 'Prioridad',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                    if($model->prioridadtarea==1){
                        return '<span class="glyphicon glyphicon-flag" style="color:green" aria-hidden="true"></span>';
                    }elseif ($model->prioridadtarea==2) {
                        return '<span class="glyphicon glyphicon-flag" style="color:orange" aria-hidden="true"></span>';
                    }else{
                        return '<span class="glyphicon glyphicon-flag" style="color:red" aria-hidden="true"></span>';
                    }
                }
            ],
            [
                'label' => 'Estado',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'attribute' => 'estadotarea0.nombre',
            ],
            


            [

                'label' => '',
                'format' => 'raw',
                'value' => function($model){
                    if($model->estadotarea == 1){
                        if(Yii::$app->user->identity->role == 17)
                            return  Html::a('Recibir',['tareamantenimiento/recibir', 'id' => $model->id], ['class' => 'btn btn-warning']);
                        else
                            return '';
                    }
                    elseif ($model->estadotarea != 4) {
                        return  Html::a('Ver',['tareamantenimiento/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                }
            ]
        ],
    ]); ?>
</div>
