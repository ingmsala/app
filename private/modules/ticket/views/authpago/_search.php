<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\AuthpagoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="authpago-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ticket') ?>

    <?= $form->field($model, 'proveedor') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'ordenpago') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
