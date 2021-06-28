<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Authpago */
/* @var $form yii\widgets\ActiveForm */
$estados =ArrayHelper::map($estados,'id', 'nombre');
$proveedores =ArrayHelper::map($proveedores,'id', function($model){
    return $model->cuit.' - '.$model->nombre;
});
?>

<div class="authpago-form">

    
<?php $form = ActiveForm::begin(); ?>



<?php

            echo FormGrid::widget([
            
            'model'=>$modelauth,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
               
                [
                    
                    'attributes'=>[       // 2 column layout
                        
                        'fecha'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\date\DatePicker', 
                            'options'=>[
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                //'value' => '23-Feb-1982',
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'dd/mm/yyyy',
                                    
                                    
                                ],
                            ]
                        ],
                        'ordenpago'=>['type'=>Form::INPUT_TEXT],   
                        'monto'=>['type'=>Form::INPUT_TEXT],   
                        
                        
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>2</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'proveedor'=>[
                            //'label' => 'Proveedor '.Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['value' => Url::to(['/ticket/proveedorpago/create']), 'title' => 'Nuevo proveedor', 'class' => 'btn btn-link amodalgenerico']),
                            'label' => 'Proveedor',
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$proveedores,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ], 
                        ],
                         
                          
                        'estado'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$estados,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ], 
                        ], 
                    ]
                ],

                
                                
                
            ]

        ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>