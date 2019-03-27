<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilla de Asistencia';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->registerJs("


  $('#btnausentes').on('click', function (e) {
    e.preventDefault();

   
    
    var keys = $('#grid').yiiGridView('getSelectedRows');

    if(keys.length > 0){
        alert(keys);
        var deleteUrl     = 'index.php?r=optativas/inasistencia/procesarausentes';
        var pjaxContainer = 'test';
        
                    $.ajax({
                      url:   deleteUrl,
                      type:  'post',
                      data: {id: key, clase: 4},
                      
                      error: function (xhr, status, error) {
                        alert('Error');
                      }
                    }).done(function (data) {
                      
                      $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                      alert('La operación se realizó correctamente');
                    });
    }else{
        alert('Debe seleccionar al menos un alumno');
    }
              
  });

"); ?>
<div class="matricula-index">

    
<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
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
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions'=>['style'=>'display: block;margin-right: auto;margin-left: auto;'],//center checkboxes
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
                'label' => 'Estado',
                'attribute' => 'estadomatricula0.nombre',
                
            ],
                        
           
        ],
        'pjax' => true,
    ]);

Pjax::end();
 ?>

    <?=Html::a(
                '<span class="glyphicon glyphicon-ok"></span> Confirmar Ausentes',
                false,
                [
                    'class'          => 'btn btn-danger',
                    'id' => 'btnausentes',
                    'delete-url'     => '/parte/procesarmarcadosreg',
                    'pjax-container' => 'test',
                    
                ]
            );
    ?>
</div>
