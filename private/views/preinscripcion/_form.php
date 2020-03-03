<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preinscripcion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'fin')->textInput() ?>

    <?php
        echo DateTimePicker::widget([
            'name' => 'dp_5',
            'type' => DateTimePicker::TYPE_BUTTON,
            'value' => '23-Feb-1982 01:10',
            'layout' => '{picker} {remove} {input}',
            'options' => [
                'type' => 'text',
                'readonly' => true,
                'class' => 'text-muted small',
                'style' => 'border:none;background:none'
            ],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy hh:ii',
                'autoclose' => true
            ]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
