<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Nombramiento;
use app\models\Agente;
use yii\helpers\Url;

?>
    
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            return ['id' => $model['id']];
        },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,

            'heading' => Html::encode('Nombramientos provisorios')
            
            ],
        'columns' => [
        
            [
                'label' => 'Cod. Cargo',
                'attribute' => 'cargo',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return $model->cargo.' - '.$model->cargo0->nombre;
                }
            ],

            [
                'label' => 'Revista',
                'attribute' => 'revista',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return Html::tag('span',  $model->revista0->nombre, ['class' => "badge"]);
                }
            ],
           
            [
                'label' => 'Agente',
                'attribute' => 'agente',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                
                'value' => function($model){

                    return $model->agente0->apellido.', '.$model->agente0->nombre;
                   //return $model->agente0->apellido.', '.$model->agente0->nombre;
                }

            ],

            [
                'label' => 'Condición',
                'attribute' => 'condicion',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return Html::tag('span',  'Provisorio', ['class' => "badge"]);
                }
            ],

                     
            
            [
                'label' => 'Función (Horas)',
                'attribute' => 'division',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model->nombre.'('.$model->horas.')';
                }
            ],
            [
                'label' => 'Suplente',
                'attribute' => 'suplente',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' =>  function($model){
                     //var_dump($model->suplente0->agente0);
                        if (isset($model->suplente0)){
                            //$suplentes = ArrayHelper::map($model, 'id', 'agente');
                            //var_dump($model->suplente0->suplente);
                            
                            return Html::tag('li', Html::tag('div',Html::tag('span', $model->suplente0->condicion0->nombre, ['class' => "badge pull-left"]).Html::tag('span', $model->suplente0->revista0->nombre, ['class' => "badge pull-right"])."&nbsp;".$model->suplente0->agente0->apellido.', '.$model->suplente0->agente0->nombre, ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                        }

                        return '';
                    }
                     
                
                //'suplente0.agente0.apellido',
            ],

            [
                'label' => 'Suplente 2',
                'attribute' => 'suplente0',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' =>  function($model){
                     //var_dump($model->suplente0->agente0);
                        if ($model->suplente0 != null){

                            if ($model->suplente0->suplente != null){
                                $supl = new Nombramiento();
                                $supl = $supl->getsuplente($model->suplente0->suplente);
                                $supl = Agente::findOne($supl['agente']);
                                //return $supl['apellido'].', '.$supl['nombre'];
                            
                            
                            //var_dump();
                                return Html::tag('li', Html::tag('div',Html::tag('span', 'SUPL', ['class' => "badge pull-left"]).Html::tag('span', 'VIGENTE', ['class' => "badge pull-right"])."&nbsp;".$supl['apellido'].', '.$supl['nombre'], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);

                            }
                        }

                        return '';
                    }
                     
                
                //'suplente0.agente0.apellido',
            ],

            ['class' => 'kartik\grid\ActionColumn',
            'visible' => ($origen=='index')?true:false],

            [
                'label' => 'Asignar',
                'visible' => ($origen=='asignar')?true:false,
                'format' => 'raw',
                'value' => function($model) use($idx){
                    return Html::a('Asignar', Url::to(['asignarprovisorio', 'suplente' =>$model->id, 'cargotitular' => $idx]), ['class' => 'btn btn-info', 
                    'data' => [
                        'confirm' => 'Está seguro que desea asignar este nombramiento como Suplente?',
                        'method' => 'post',
                    ],]);
                }
            ],

            
        ],

         'toolbar'=>[
            ['content' => 
               ''

               
            ],
            '',
            
        ],
        //'floatHeader'=>true,
        'summary'=>false,
        
        
    ]); ?>

