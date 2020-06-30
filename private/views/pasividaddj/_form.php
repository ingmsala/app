<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pasividaddj */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasividaddj-form">

<?php $form = ActiveForm::begin(['method' => 'POST', 'id' => 'registration-pasividades',]); ?>

<?php
    echo FormGrid::widget([
        
        'model'=>$model,
        'form'=>$form,
        'autoGenerateColumns'=>true,
        'rows'=>[
            [
                'attributes'=>[       // 2 column layout
                    
                    'regimen'=>['type'=>Form::INPUT_TEXT],
                    'causa'=>['type'=>Form::INPUT_TEXT],
                    'caja'=>['type'=>Form::INPUT_TEXT],
                                            
                ]
            ],

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
                    //'importe'=>['type'=>Form::INPUT_TEXT],
                    'percibe'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        
                        'widgetClass'=>'\kartik\select2\Select2', 
                        'options'=>['data'=>['0' => 'Suspendido', '1' => 'Percibo']], 
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
