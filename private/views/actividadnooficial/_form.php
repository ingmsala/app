<?php

use yii\helpers\Html;

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;

?>

<div class="actividadnooficial-form">
<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
    <?php $form2 = ActiveForm::begin(['id' => 'registration-nooficiales', 'enableClientValidation' => true,  'options' => ['data-pjax' => true]]); ?>

    <?php
       
        echo FormGrid::widget([
            
            'model'=>$model,
            'form'=>$form2,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    'attributes'=>[       // 2 column layout
                        
                        'empleador'=>['type'=>Form::INPUT_TEXT],
                        'lugar'=>['type'=>Form::INPUT_TEXT],
                        'sueldo'=>['type'=>Form::INPUT_TEXT],
                                                
                    ]
                ],

                [
                    'attributes'=>[       // 2 column layout
                        
                        'ingreso'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'label' => 'Desde',
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
                        'funcion'=>['type'=>Form::INPUT_TEXT],
                        
                    ]
                ],

                
            ]
    ]);
    
    ?>

<legend class="text-info"><small>Horario</small></legend>

<?php
       
       echo FormGrid::widget([
           
           'model'=>$modelhorario,
           'form'=>$form2,
           'autoGenerateColumns'=>true,
           'rows'=>[
                [
                        
                    'attributes'=>[       // 2 column layout
                        
                        'inicio'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'label' => 'Desde',
                            'widgetClass'=>'\yii\widgets\MaskedInput', 
                            'options'=>['mask' => '99:99',]
                        ],   
                        'fin'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'label' => 'Hasta',
                            'widgetClass'=>'\yii\widgets\MaskedInput', 
                            'options'=>['mask' => '99:99',]
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
    <?php yii\widgets\Pjax::end() ?>

</div>
