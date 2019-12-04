<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TareamantenimientoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareamantenimiento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'responsable') ?>

    <?= $form->field($model, 'estadotarea') ?>

    <?php // echo $form->field($model, 'novedadparte') ?>

    <?php // echo $form->field($model, 'prioridadtarea') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
