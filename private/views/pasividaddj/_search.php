<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasividaddjSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasividaddj-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'regimen') ?>

    <?= $form->field($model, 'causa') ?>

    <?= $form->field($model, 'caja') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'importe') ?>

    <?php // echo $form->field($model, 'percibe') ?>

    <?php // echo $form->field($model, 'declaracionjurada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
