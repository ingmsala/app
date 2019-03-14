<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente - Control Regencia';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php



$this->registerJs("


  $('#ratifall').on('click', function (e) {
    e.preventDefault();
   
    
    var keys = $('#grid').yiiGridView('getSelectedRows');
    if(keys.length > 0){
        var deleteUrl     = 'index.php?r=parte/procesarmarcadosreg';
        var pjaxContainer = 'test';
        
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys},
                      beforeSend: function() {
                         $('#loader').show();
                      },
                      error: function (xhr, status, error) {
                        alert('Error');
                      }
                    }).done(function (data) {
                       $('#loader').hide();
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                      alert('La operación se realizó correctamente');
                    });
    }else{
        alert('Debe seleccionar al menos una instancia');
    }
              
  });

");

$this->registerJs("


  $('#rectifall').on('click', function (e) {
    e.preventDefault();
   
    
    var keys = $('#grid').yiiGridView('getSelectedRows');
    if(keys.length > 0){
        var deleteUrl     = 'index.php?r=parte/procesarmarcadosregrec';
        var pjaxContainer = 'test';
        
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys},
                      beforeSend: function() {
                         $('#loader').show();
                      },
                      error: function (xhr, status, error) {
                        alert('Error');
                      }
                    }).done(function (data) {
                       $('#loader').hide();
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                      alert('La operación se realizó correctamente');
                    });
    }else{
        alert('Debe seleccionar al menos una instancia');
    }
              
  });

");


?>

<div class="detalleparte-index">

    

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            
                            //var_dump($param);
                            
                            $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',]; 

                            $years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023'];

                            $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
                                    return $doc['apellido'].', '.$doc['nombre'];}
                            );

                            $listEstadoinasistencia=ArrayHelper::map($estadoinasistencia,'id','nombre');

                            $filter = false;
                            
                            if(isset($param['Detalleparte']['anio'])){
                                if($param['Detalleparte']['anio']!=''){
                                    $filter = true;
                                    echo '<b> - Año: </b>'.$years[$param['Detalleparte']['anio']];
                                }
                            }

                            if(isset($param['Detalleparte']['mes'])){
                                if($param['Detalleparte']['mes']!=''){
                                    $filter = true;
                                    echo '<b> - Mes: </b>'.$meses[$param['Detalleparte']['mes']];
                                    
                                }
                            }

                            if(isset($param['Detalleparte']['docente'])){
                                if($param['Detalleparte']['docente']!=''){
                                    $filter = true;
                                    echo '<b> - Docente: </b>'.$listDocentes[$param['Detalleparte']['docente']];
                                    
                                }
                            }

                            if(isset($param['Detalleparte']['estadoinasistencia'])){
                                if($param['Detalleparte']['estadoinasistencia']!=''){
                                    $filter = true;
                                    echo '<b> - Estado: </b>'.$listEstadoinasistencia[$param['Detalleparte']['estadoinasistencia']];
                                    
                                }
                            }

                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=parte/controlregencia"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
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
                                    'action' => ['controlregencia'],
                                    'method' => 'get',
                                ]); ?>

                            <?= 

                                $form->field($model, 'anio')->widget(Select2::classname(), [
                                    'data' => $years,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año");

                            ?>

                            <?= 
                                
                                $form->field($model, 'mes')->widget(Select2::classname(), [
                                    'data' => $meses,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Mes");

                            ?>

                            <?= $form->field($model, 'docente')->widget(Select2::classname(), [
                                    'data' => $listDocentes,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Docente");

                            ?>

                            <?= $form->field($model, 'estadoinasistencia')->widget(Select2::classname(), [
                                    'data' => $listEstadoinasistencia,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Estado");

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

<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
<div id="loader"></div>
    <?= 

GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,

        'rowOptions' => function($model){
            if ($model['cont'] > 1){
                return [
                    'class' => 'warning',
                    'data' => [
                        'key' => $model['id']
                    ],

            ];
            }
            return [
                'data' => [
                    'key' => $model['id']
                ]
            ];
        },

        //'filterModel' => $searchModel,
        'columns' => [
            
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    if ($model['estadoinasistenciax'] == 2)
                        return ['disabled' => 'disabled'];
                }
                // you may configure additional properties here
            ],

           [   
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                    //var_dump($model);
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                    
                }
            ],
            [   
                'label' => 'División',
                'attribute' => 'division',
                'value' => function($model){
                    return $model['division'];
                }
            ],
            [   
                'label' => 'Hora',
                'attribute' => 'hora',
                'value' => function($model){
                    return $model['hora'];
                }
            ],
            [   
                'label' => 'Apellido',
                'attribute' => 'apellido',
                'value' => function($model){
                    return $model['apellido'];
                }
            ],
            [   
                'label' => 'Nombre',
                'attribute' => 'nombred',
                'value' => function($model){
                    return $model['nombred'];
                }
            ],
            [   
                'label' => 'Llegó',
                'attribute' => 'llego',
                'value' => function($model){
                    return $model['llego'];
                }
            ],
            [   
                'label' => 'Retiró',
                'attribute' => 'retiro',
                'value' => function($model){
                    return $model['retiro'];
                }
            ],
            [   
                'label' => 'Tipo de falta',
                'attribute' => 'falta',
                'value' => function($model){
                    return $model['falta'];
                }
            ],
            [   
                'label' => 'Estado',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'attribute' => 'estadoinasistenciaxtxt',
                'value' => function($model){
                        
                        return $model['estadoinasistenciaxtxt'];
                        
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg}',
                
                'buttons' => [
                    'savereg' => function($url, $model, $key){

                        //return Html::a('<span class=" modalRegencia glyphicon glyphicon-plus"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        if ($model['estadoinasistenciax'] != 2){
                            return $model['id'] != '' ? Html::button('<span class="glyphicon glyphicon-edit"></span> Rectificar', ['value' => Url::to('index.php?r=estadoinasistenciaxparte/create&detalleparte='.$model['id'].'&estadoinasistencia=3'), 'class' => 'modalRegencia btn btn-danger',  ]) : '';
                        }
                    },
                    
                ]

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg2}',
                
                'buttons' => [
                    'savereg2' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);

                        if ($model['estadoinasistenciax'] != 2){
                         return Html::a('<span class="glyphicon glyphicon-ok"></span>', '?r=estadoinasistenciaxparte/nuevoestado&detalleparte='.$model['id'].'&estadoinasistencia=2', ['class' => 'btn btn-success',
                            'data' => [
                            'confirm' => '¿Está seguro de querer cerrar la inasistencia del docente?',
                            'method' => 'post',
                             ]
                            
                            ]);
                        }

                         
                    },
                    
                ]

            ],
        ],
        'pjax' => true,
]);



Pjax::end();

echo Html::a(
                            '<span class="glyphicon glyphicon-edit"></span> Rectificar Seleccionados',
                            false,
                            [
                                'class'          => 'btn btn-danger',
                                'id' => 'rectifall',
                                'delete-url'     => '/parte/procesarmarcadosregrec',
                                'pjax-container' => 'test',
                                
                            ]
                        );

echo Html::a(
                            '<span class="glyphicon glyphicon-ok"></span> Ratificar Seleccionados',
                            false,
                            [
                                'class'          => 'btn btn-success',
                                'id' => 'ratifall',
                                'delete-url'     => '/parte/procesarmarcadosreg',
                                'pjax-container' => 'test',
                                
                            ]
                        );




/*echo Html::button('Save', ['class' => 'btn btn-primary', 'onclick' => 
                    "var keys = $('#grido').yiiGridView('getSelectedRows');
                    console.log(keys);
                    $.ajax({
                    type: 'POST',
                    url: '".Url::to(['parte/procesarmarcadosreg'])."',
                    dataType: 'json',
                    data: {keylist: keys}});"]) 
*/
    /*GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [

           [   
                'label' => 'Fecha',
                'attribute' => 'parte0.fecha',
                'value' => function($model){
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                }
            ],

            [   
                'label' => 'Division',
                'attribute' => 'division0.nombre'
            ],

            [   
                'label' => 'Hora',
                'attribute' => 'hora0.nombre'
            ],

            
            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],

            'llego', 
            'retiro',
            [   
                'label' => 'Tipo de Falta',
                'attribute' => 'falta0.nombre'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg}',
                
                'buttons' => [
                    'savereg' => function($url, $model, $key){

                        //return Html::a('<span class=" modalRegencia glyphicon glyphicon-plus"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);

                        return $model->id != '' ? Html::button('Rectificar', ['value' => Url::to('index.php?r=estadoinasistenciaxparte/create&detalleparte='.$model->id.'&estadoinasistencia=3'), 'class' => 'modalRegencia btn btn-danger',  ]) : '';
                    },
                    
                ]

            ],
/*
             [   
                
                'label' => 'Control Regencia',
                'format' => 'raw',
                'attribute' => 'falta0.nombre',
                'value' => function($model)
                {
                    var_dump($model->falta);
                    return Select2::widget([
                        'model' => $model,
                        'attribute' => 'falta',
                        'data' => [ 1 =>'Ratificar', 2 =>'Comisión', 
                                    
                                   ],
                        'hideSearch' => true,
                        'options' => [
                                        'id' => 'falta'.$model->id,
                                        'name' => 'falta'.$model->id,
                                     ],
                        'pluginOptions' => [
                                 'allowClear' => false,
                        ],
                    ]);
                },
            ],
*//*
            [   
                'label' => 'Estados',
                'attribute' => 'estadoinasistenciaxpartes.nombre',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model){
                    $items = [];
                    $itemsc = [];

                                        
                    foreach($model->estadoinasistenciaxpartes as $estadoinasistenciaxparte){
                         $itemsc[] = [$estadoinasistenciaxparte->fecha, $estadoinasistenciaxparte->estadoinasistencia0->nombre, $estadoinasistenciaxparte->falta0->nombre];
                        
                    }

                    sort($itemsc);

                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                        //$formatter = \Yii::$app->formatter;
                            return 
                                //Html::tag('li', Html::tag('div', Html::tag('span', $formatter->asDate($item[0], "dd/MM/yyyy - HH:i"), ['class' => "badge pull-right"])."&nbsp;".$item[1], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                            Html::tag('li', Html::tag('div', Html::tag('span', $item[2], ['class' => "badge pull-right"])."&nbsp;".$item[1], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                            }
                            
                    , 'class' => "nav nav-pills nav-stacked"]);


                    //return var_dump($model->estadoinasistenciaxpartes);
               }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg}',
                
                'buttons' => [
                    'savereg' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);

                         return Html::a('<span class="glyphicon glyphicon-ok"></span>', '?r=estadoinasistenciaxparte/nuevoestado&detalleparte='.$model->id.'&estadoinasistencia=2', ['class' => 'btn btn-success',
                            'data' => [
                            'confirm' => 'Está seguro de querer cerrar la inasistencia del docente?',
                            'method' => 'post',
                             ]
                            
                     ]);

                         
                    },
                    
                ]

            ],
        ],
    ]);*/ ?>
</div>
