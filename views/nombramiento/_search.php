<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NombramientoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nombramiento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'cargo') ?>

    <?= $form->field($model, 'horas') ?>

    <?= $form->field($model, 'docente') ?>

    <?php  echo $form->field($model, 'revista') ?>

    <?php  echo $form->field($model, 'division') ?>

    <?php  echo $form->field($model, 'suplente') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
