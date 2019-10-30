<?php

use kartik\form\ActiveForm;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agregar alumnos al acta';

$porcentaje =round($cantenacta*100/($cantenacta+$cantsinacta),0);

?>

<h2>Agregar alumnos al acta de <?= $model->comision0->optativa0->actividad0->nombre.' ('.$model->nombre.')' ?></h2>
<div class="clearfix"></div>
<?php $form = ActiveForm::begin([
        'action' => ['detalleacta/altaacta', 'id' => $model->id],
        'method' => 'post',
    ]); ?>
    <?php  echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
<div class="row">
    <div class="col-md-5">
        
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'grid',
                'floatHeader' => true,
                'perfectScrollbar' => true,
                'rowOptions' => function($model)/* use ($listInasistenciasdeldia)*/{
                    /* if (in_array ($model['id'], $listInasistenciasdeldia)){
                        return [
                            'class' => 'danger',
                            'data' => [
                                'key' => $model['id']
                            ],

                    ];
                    }*/
                    return [
                        'data' => [
                            'key' => $model['id']
                        ]
                    ];
                },
                //'filterModel' => $searchModel,
                'panel' => [
                    'type' => GridView::TYPE_DANGER,
                    'heading' => Html::encode('Alumnos sin acta'),
                    //'beforeOptions' => ['class'=>'kv-panel-before'],
                ],
                'summary' => false,

                

                'toolbar'=>[
                    
                    
                    
                ],
                'columns' => [
                    
                   
                    
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

                    
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'hiddenFromExport' => true,
                        'width' => '2%',
                        'checkboxOptions' => 
                            function($model, $key, $index, $column) {
                            return false;
                             
                         },
                        'header' => Html::checkBox('selection_all', false, [
                        //'label' => '<span>Agregar</span>',//pull left the label
                        'class' => 'select-on-check-all',//pull right the checkbox
                        
                  
                         ]),
                    ],
                    [
                        'label' => 'Alumno',
                        'width' => '98%',
                        'value' => function($model){
                            return $model->alumno0->apellido.', '.$model->alumno0->nombre;
                        }
                    ],
                    
                                
                   
                ],
                
            ]);


         ?>
    </div>
    <div class="col-md-2">
        <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span><br />Agregar alumnos <br />seleccionados', ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <div class="col-md-5">
        <?= GridView::widget([
        'dataProvider' => $dataProviderDetacta,
        'id' => 'grid22',
        'floatHeader' => true,
        'perfectScrollbar' => true,
        'responsiveWrap' => false,

        /*'rowOptions' => function($model) use ($listInasistenciasdeldia){
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
        },*/
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => Html::encode('Alumnos en el acta: ').$porcentaje.'%',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        

        'toolbar'=>[
            
            
            
        ],
        'columns' => [
            
            
            [
                'label' => 'Alumno',
                'value' => function($model){
                    return $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;
                }
            ]
            
            
            
                        
           
        ],
        
    ]);


 ?>
    </div>
</div>

<?php ActiveForm::end(); ?>



 <p>
<span class="pull-right">
 
        <?= Html::a('Siguiente >', ['detalleacta/index', 'acta_id' => $model->id], ['class' => 'btn btn-success']) ?>
    
</span>
</p>




<div>

 

  

    <div class="clearfix">

</div>
    
    
 
   

    

</div>
