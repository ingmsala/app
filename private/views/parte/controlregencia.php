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
                      data: {id: key, or: 2},
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

<div>
        
    <?= $this->render('_filtro', [
        'model' => $model,
        'docentes' => $docentes,
        'estadoinasistencia' => $estadoinasistencia,
        'param' => $param,
        'origen' => 'controlregencia',
    ]) ?>

</div>

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
                            return $model['id'] != '' ? Html::button('<span class="glyphicon glyphicon-edit"></span> Rectificar', ['value' => Url::to('index.php?r=estadoinasistenciaxparte/create&detalleparte='.$model['id'].'&estadoinasistencia=3'), 'class' => 'modalRegencia btn btn-danger btn-sm',  ]) : '';
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
                         return Html::a('<span class="glyphicon glyphicon-ok"></span>', '?r=estadoinasistenciaxparte/nuevoestado&detalleparte='.$model['id'].'&estadoinasistencia=2', ['class' => 'btn btn-success btn-sm',
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
/*
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
*/
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
