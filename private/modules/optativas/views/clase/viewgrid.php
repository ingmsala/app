<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilla de Asistencia';

?>

<?php $listInasistenciasdeldia=ArrayHelper::map($inasistenciasdeldia,'matricula','matricula'); ?>
<?php $listAlumnosdecomision=ArrayHelper::map($alumnosdecomision,'id','id'); ?>
<?php 
     $presentes =array_diff($listAlumnosdecomision, $listInasistenciasdeldia);
     $presentestxt = implode(",",$listAlumnosdecomision);

?>

<?php $this->registerJs("
    

 


  $('#btnausentes').on('click', function (e) {
    e.preventDefault();

      
    
    var keys = $('#grid').yiiGridView('getSelectedRows');


    if(keys.length < 1){
        keys = [0];
    }
        
        var deleteUrl     = 'index.php?r=optativas/inasistencia/procesarausentes';
        var clase     = ".$clase.";
        var presentes     = '".$presentestxt."';
        var pjaxContainer = 'test';
        
                    
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: keys, clase: clase, presentes: presentes},
                      
                      error: function (xhr, status, error) {
                        alert(error);
                      }
                    }).done(function (data) {
                      
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                      
                      window.location.href = 'index.php?r=optativas%2Fclase%2Fviewgrid&id='+ clase;

                      alert('La operación se realizó correctamente');
                    });
    
              
  });

"); ?>

<div style="margin-top: -50px;">

<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        'floatHeader'=>true,
        'rowOptions' => function($model) use ($listInasistenciasdeldia){
             if (in_array ($model['id'], $listInasistenciasdeldia)){
                return [
                    'class' => 'danger',
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
            
            '{export}',
            
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'hiddenFromExport' => true,
                
                'checkboxOptions' => 
                    function($model, $key, $index, $column) use ($listInasistenciasdeldia) {

                     $bool = in_array($model->id, $listInasistenciasdeldia);
                     return ['checked' => $bool];
                 },
                'header' => Html::checkBox('selection_all', false, [
                'label' => '<span>Ausentes</span>',//pull left the label
                'class' => 'select-on-check-all',//pull right the checkbox
                
          
        ]),
            ],
            ['class' => 'yii\grid\SerialColumn'],
            
            /*[
                'label' => 'Optativa',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['optativa0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'];
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],*/

            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => 'Matrícula',
                'attribute' => 'estadomatricula0.nombre',
                
            ],
            [
                'label' => 'En clase',
                'value' => function($model) use ($listInasistenciasdeldia) {
                     if (in_array ($model['id'], $listInasistenciasdeldia)){
                        return "AUSENTE";
                    }
                    return "PRESENTE";
                }
            ],
                        
           
        ],
        'pjax' => true,
    ]);

Pjax::end();
 ?>
 <div class="pull-right">
    <?=Html::a(
                '<span class="glyphicon glyphicon-ok"></span> Confirmar Ausentes',
                false,
                [
                    'class' => 'btn btn-primary',
                    'id' => 'btnausentes',
                    'delete-url'     => '/parte/procesarmarcadosreg',
                    'pjax-container' => 'test',
                    
                ]
            );
    ?>
</div>

</div>
