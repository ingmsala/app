<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleparteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalleparte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parte') ?>

    <?= $form->field($model, 'division') ?>

    <?= $form->field($model, 'agente') ?>

    <?= $form->field($model, 'hora') ?>

    <?php // echo $form->field($model, 'llego') ?>

    <?php // echo $form->field($model, 'retiro') ?>

    <?php // echo $form->field($model, 'falta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
