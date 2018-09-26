<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-catedra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catedra')->textInput() ?>
    <?= Html::tag('span', $catedra) ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'docente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condicion')->textInput() ?>

    <?= $form->field($model, 'revista')->textInput() ?>

    <?= $form->field($model, 'resolucion')->textInput() ?>

    <?= $form->field($model, 'fechaInicio')->textInput() ?>

    <?= $form->field($model, 'fechaFin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
