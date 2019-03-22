<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente - Control Secretaría';

?>

<?php 

$this->registerJs("


  $('#justifall').on('click', function (e) {
    e.preventDefault();
   
    
    var keys = $('#grid').yiiGridView('getSelectedRows');
    if(keys.length > 0){
        var deleteUrl     = 'index.php?r=parte/procesarmarcadosreg';
        var pjaxContainer = 'test';
        
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys, or: 4},
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
        'origen' => 'controlsecretaria',
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
                    if ($model['estadoinasistenciax'] != 2)
                        return ['disabled' => 'disabled'];
                }
                // you may configure additional properties here
            ],

           [   
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    //var_dump($model);
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                    
                }
            ],
            [   
                'label' => 'División',
                'attribute' => 'division',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['division'];
                }
            ],
            [   
                'label' => 'Hora',
                'attribute' => 'hora',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['hora'];
                }
            ],
            [   
                'label' => 'Apellido',
                'attribute' => 'apellido',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['apellido'];
                }
            ],
            [   
                'label' => 'Nombre',
                'attribute' => 'nombred',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['nombred'];
                }
            ],
            [   
                'label' => 'Llegó',
                'attribute' => 'llego',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['llego'];
                }
            ],
            [   
                'label' => 'Retiró',
                'attribute' => 'retiro',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['retiro'];
                }
            ],
            [   
                'label' => 'Tipo de falta',
                'attribute' => 'falta',
                'vAlign' => 'middle',
                'hAlign' => 'center',
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
                'template' => '{savesec}',
                'visibleButtons'=> [
                        'savesec' => function(){

                    return !in_array (Yii::$app->user->identity->role, [6]);

                }

                ],
                
                'buttons' => [
                    'savesec' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        //return Html::a('<span class="glyphicon glyphicon-ok"></span>',false,['class' => 'btn btn-success']);
                        if ($model['estadoinasistenciax'] == 2){
                            return Html::a('Justificar', '?r=estadoinasistenciaxparte/nuevoestado&detalleparte='.$model['id'].'&estadoinasistencia=4', ['class' => 'btn btn-warning btn-sm',
                            'data' => [
                            'confirm' => 'Está seguro de querer justificar la inasistencia del docente?',
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
if (!in_array (Yii::$app->user->identity->role, [6])){
echo Html::a(
                            '<span class="glyphicon glyphicon-ok"></span> Justificar Seleccionados',
                            false,
                            [
                                'class'          => 'btn btn-warning',
                                'id' => 'justifall',
                                'delete-url'     => '/parte/procesarmarcadosreg',
                                'pjax-container' => 'test',
                                
                            ]
                        );
}
 ?>
</div>
