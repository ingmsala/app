<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-catedra-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'docente') ?>

    <?= $form->field($model, 'catedra') ?>

    <?= $form->field($model, 'condicion') ?>

    <?= $form->field($model, 'revista') ?>

    <?php // echo $form->field($model, 'resolucion') ?>

    <?php // echo $form->field($model, 'fechaInicio') ?>

    <?php // echo $form->field($model, 'fechaFin') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
