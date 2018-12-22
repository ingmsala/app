<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\NombramientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nombramientos';

?>
<div class="nombramiento-index">

       
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title)
            
            ],
        'columns' => [
        
            [
                'label' => 'Cod. Cargo',
                'attribute' => 'cargo',
                'filter' =>ArrayHelper::map($dataProvider->models, 'cargo', 'cargo0.nombre'),
                'filterInputOptions' => ['prompt' => 'Todos', 'class' => 'form-control', 'id' => null],
                'value' => function($model){

                   return $model->cargo.' - '.$model->cargo0->nombre;
                }
            ],
           
            [
                'label' => 'Docente',
                'attribute' => 'docente',
                'format' => 'raw',
                'value' => function($model){

                    return Html::tag('li', Html::tag('div',Html::tag('span', $model->condicion0->nombre, ['class' => "badge pull-left"]).Html::tag('span', $model->revista0->nombre, ['class' => "badge pull-right"])."&nbsp;".$model->docente0->apellido.', '.$model->docente0->nombre, ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                   //return $model->docente0->apellido.', '.$model->docente0->nombre;
                }

            ],

            'nombre',
            'horas',
                        
            
            
            [
                'label' => 'Division',
                'attribute' => 'division',
                'value' => 'division0.nombre',
            ],
            [
                'label' => 'Suplente',
                'attribute' => 'suplente',
                'format' => 'raw',
                'value' =>  function($model){
                     //var_dump($model->suplente0->docente0);
                        if (isset($model->suplente0)){
                            return Html::tag('li', Html::tag('div',Html::tag('span', $model->suplente0->condicion0->nombre, ['class' => "badge pull-left"]).Html::tag('span', $model->suplente0->revista0->nombre, ['class' => "badge pull-right"])."&nbsp;".$model->suplente0->docente0->apellido.', '.$model->suplente0->docente0->nombre, ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                        }

                        return '';
                    }
                     
                
                //'suplente0.docente0.apellido',
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
         'toolbar'=>[
            ['content' => 
                Html::a('Nuevo Nombramiento', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'exportConfig' => [
            GridView::EXCEL => ['label' => 'Excel'],
            //GridView::HTML => [// html settings],
            //GridView::PDF => ['label' => 'PDF'],
        ]
        
    ]); ?>
</div>
