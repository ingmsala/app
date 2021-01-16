<?php

use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Reunionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reunionedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                
            ]);
        ?>

    </div>

    <?= $form->field($model, 'hora')->widget(TimePicker::classname(), [

        'pluginOptions' => [
                
                'showMeridian' => false,
                'minuteStep' => 1,
                'defaultTime' => false,

            ]

        ]); 
    ?>

    <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tematica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
