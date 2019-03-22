<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;


/* @var $
this yii\web\View */
/* @var $searchModel app\models\CatedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catedras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-index">

    

    <?php
        $listdivisiones=ArrayHelper::map($divisiones,'nombre','nombre');
        $listPropuestas=ArrayHelper::map($propuestasall,'id','nombre');
        $listResoluciones=ArrayHelper::map($resoluciones,'resolucion','resolucion');
        $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );
    ?>
    
    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filter = false;
                            if(isset($param['Catedra']['propuesta'])){
                                if($param['Catedra']['propuesta']!=''){
                                    $filter = true;
                                    echo '<b> - Propuesta: </b>'.$listPropuestas[$param['Catedra']['propuesta']];
                                }
                            }

                            if(isset($param['Catedra']['docente'])){
                                if($param['Catedra']['docente']!=''){
                                    $filter = true;
                                    echo '<b> - Docente: </b>'.$listDocentes[$param['Catedra']['docente']];
                                    
                                }
                            }

                            if(isset($param['Catedra']['actividadnom'])){
                                if($param['Catedra']['actividadnom']!=''){
                                    $filter = true;
                                    echo '<b> - Actividad: </b>'.$param['Catedra']['actividadnom'];
                                    
                                }
                            }

                            if(isset($param['Catedra']['divisionnom'])){
                                if($param['Catedra']['divisionnom']!=''){
                                    $filter = true;
                                    echo '<b> - Division: </b>'.$param['Catedra']['divisionnom'];
                                    
                                }
                            }

                            if(isset($param['Catedra']['resolucion'])){
                                if($param['Catedra']['resolucion']!=''){
                                    $filter = true;
                                    echo '<b> - Resolución: </b>'.$param['Catedra']['resolucion'];
                                    
                                }
                            }


                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=catedra/index"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['index'],
                                    'method' => 'get',
                                ]); ?>

                            <?= 

                                $form->field($model, 'propuesta')->widget(Select2::classname(), [
                                    'data' => $listPropuestas,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Propuesta Formativa");

                            ?>

                            <?= 
                                
                                $form->field($model, 'docente')->widget(Select2::classname(), [
                                    'data' => $listDocentes,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Docente");

                            ?>
                        
                            <?= $form->field($model, 'actividadnom')->textInput()->label("Actividad") ?>

                            <?= $form->field($model, 'divisionnom')->textInput()->label("División") ?>

                            <?= 
                                
                                $form->field($model, 'resolucion')->widget(Select2::classname(), [
                                    'data' => $listResoluciones,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Resolución");

                            ?>

                            <div class="form-group">
                                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Resetear', ['class' => 'btn btn-default']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
        

       
    <?php
    
    
    Pjax::begin();
     echo GridView::widget([
        'dataProvider' => $dataProvider,
        
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
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                Html::a('Nueva Catedra', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'columns' => [

            [   
                'label' => 'Propuesta',
                'attribute' => 'propuesta',
                'vAlign' => 'middle',
                //'value' => 'actividad0.nombre',
                'group' => true,
                
            ],
            
            [   
                'label' => 'Division',
                'attribute' => 'division',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                //'value' => 'division0.nombre',
                'group' => true,
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
                'group' => true,
                'filter' => [
                    'name' => 'actividad',
                    
                ],
            ],

            [   
                'label' => 'Hora Total',
                'attribute' => 'horaact',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                
            ],

            [   
                'label' => 'Horas Detalle',
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
                'attribute' => 'docente',
                'value' => function ($model){
                    if($model['activo'] != 2){
                        return $model['docente'];
                    }
                }
                /*'format' => 'raw',
                'value' => function($model){
                    $items = [];
                    $itemsc = [];
                    //var_dump($model);
       
                    foreach($model->detallecatedras as $detallecatedra){

                        
                        $itemsc[] = [$detallecatedra->condicion0->id, $detallecatedra->condicion0->nombre, $detallecatedra->docente0->apellido.', '.$detallecatedra->docente0->nombre, $detallecatedra->revista0->nombre, $detallecatedra->hora, $detallecatedra->activo];
                        
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


