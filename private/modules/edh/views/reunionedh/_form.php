<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\time\TimePicker;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Reunionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reunionedh-form">

    <?php $form = ActiveForm::begin();

    echo FormGrid::widget([
    
        'model'=>$model,
        'form'=>$form,
        'autoGenerateColumns'=>true,
        'rows'=>[
            [
                'attributes'=>[
                    'fecha'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\date\DatePicker', 
                        'options'=>[
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd/mm/yyyy',
                            ],
                            'options' => ['style' => 'cursor: pointer;']
                        ]
                    ],
                    'hora'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\time\TimePicker', 
                        'options'=>[
                            'pluginOptions' => [
                
                                'showMeridian' => false,
                                'minuteStep' => 1,
                                'defaultTime' => false,
                
                            ]
                        ]
                    ],
                    'lugar'=>['type'=>Form::INPUT_TEXT],
                ]
            ],
            [
                'attributes'=>[
                    'tematica'=>['type'=>Form::INPUT_TEXT],
                    'url'=>['type'=>Form::INPUT_TEXT],
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
