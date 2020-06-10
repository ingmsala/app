<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActividadnooficialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividadnooficial-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'empleador') ?>

    <?= $form->field($model, 'lugar') ?>

    <?= $form->field($model, 'sueldo') ?>

    <?= $form->field($model, 'ingreso') ?>

    <?php // echo $form->field($model, 'funcion') ?>

    <?php // echo $form->field($model, 'declaracionjurada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
