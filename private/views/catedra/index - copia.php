<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $
this yii\web\View */
/* @var $searchModel app\models\CatedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catedras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Catedra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php
    $listdivisiones=ArrayHelper::map($divisiones,'nombre','nombre');
    $listpropuestas=ArrayHelper::map($propuestas,'id','nombre');
    
    Pjax::begin();
     echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if ($model['revista'] =='VIGENTE' && $model['activo'] != 2){
                return ['class' => 'success'];
            }
            return ['class' => 'warning'];
        },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            
            '{export}',
            
        ],
        'columns' => [

            [   
                'label' => 'Propuesta',
                'attribute' => 'propuesta',
                'vAlign' => 'middle',
                //'value' => 'actividad0.nombre',
                'group' => true,
                'filter' => Select2::widget([
                    'name' => 'propuesta',
                    'data' => $listpropuestas,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => '-',
                        'hideSearch' => false,
                        
                    ]
                ]),
            ],
            
            [   
                'label' => 'Division',
                'attribute' => 'division',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                //'value' => 'division0.nombre',
                //'group' => true,
                'filter' => Select2::widget([
                    'name' => 'division',
                    'data' => $listdivisiones,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => '-',
                        
                    ]
                ]),
               /* 'filter' => ['1A' => '1A', 'M1P' => 'M1P', 'MPB' => 'MPB', 'T2P' => 'T2P', 'T1P' => 'T1P', 'TPB' => 'TPB'],
                'filterInputOptions' => ['prompt' => 'Todas', 'class' => 'form-control', 'id' => null]*/

            ],
            
            [   
                'label' => 'Actividad',
                'attribute' => 'actividad',
                'vAlign' => 'middle',
                //'value' => 'actividad0.nombre',
                //'group' => true,
                'filter' => [
                    'name' => 'actividad',
                    
                ],
            ],

            [   
                'label' => 'Horas',
                'attribute' => 'hora',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    if($model['activo'] != 2){
                        return $model['hora'];
                    }
                }

                //'value' => 'actividad0.cantHoras',
                
            ],

            [
                    'class' => 'kartik\grid\BooleanColumn',
                    'attribute' => 'revista', 
                    'hiddenFromExport' => true,
                    'label' => '',
                    'vAlign' => 'middle',
                    'value' => function ($model){
                        if($model['activo'] != 2){
                            if ($model['revista'] == 'VIGENTE')
                             return true;
                            elseif ($model['revista'] == '')
                                return null;
                            else

                             return false;
                        }
                        return null;
                    }
            ], 

            [
                    'label' => 'Revista',
                    'format' => 'raw',
                    'attribute' => 'revista',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'value' => function($model){
                        if($model['activo'] != 2){
                            return Html::tag('span', $model['revista'], ['class' => "badge"]);
                        }
                    }
            ],
            
            
            [
                'attribute' => 'agente',
                'value' => function ($model){
                    if($model['activo'] != 2){
                        return $model['agente'];
                    }
                }
                /*'format' => 'raw',
                'value' => function($model){
                    $items = [];
                    $itemsc = [];
                    //var_dump($model);
       
                    foreach($model->detallecatedras as $detallecatedra){

                        
                        $itemsc[] = [$detallecatedra->condicion0->id, $detallecatedra->condicion0->nombre, $detallecatedra->agente0->apellido.', '.$detallecatedra->agente0->nombre, $detallecatedra->revista0->nombre, $detallecatedra->hora, $detallecatedra->activo];
                        
                    }

                    sort($itemsc);                   
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                        if($item[5]==1){
                            if($item[0]!=5){//suplente
                                return 
                                    Html::tag('li', 
                                        Html::tag('div',
                                            Html::tag('span', $item[1].' ('.$item[4].'hs.)', ['class' => "badge pull-left"]).
                                            Html::tag('span', $item[3], ['class' => "badge pull-right"])."&nbsp;".$item[2], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                                
                            }

                            return 
                                    Html::tag('li', 
                                        Html::tag('div',
                                            Html::tag('span', $item[1].' ('.$item[4].'hs.)', ['class' => "badge pull-left"]).
                                            Html::tag('span', $item[3], ['class' => "badge pull-right"])."&nbsp;".$item[2], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-warning']);
                        }
                    }, 'class' => "nav nav-pills nav-stacked"]);
                }*/],
                
                [
                    'label' => 'Condicion',
                    'format' => 'raw',
                    'attribute' => 'condicion',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'value' => function($model){
                        if($model['activo'] != 2){
                            return Html::tag('span', $model['condicion'], ['class' => "badge"]);
                        }
                    }
                ],
                



            
            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{viewdetcat} ',

                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=catedra/view&id='.$model['id']);
                    },
                    /*
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=catedra/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },*/
                ]

            ],
/*
             [
                'label' => 'Accion',
                'format' => 'raw',
                
                

                
                'value' => function($model){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=catedra/view&id='.$model['id']);
                    },
                    
                

            ],*/
        ],
    ]);
    Pjax::end();
     ?>
</div>


