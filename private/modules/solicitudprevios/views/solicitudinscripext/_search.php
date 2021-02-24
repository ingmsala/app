<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\SolicitudinscripextSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitudinscripext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'apellido') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'documento') ?>

    <?= $form->field($model, 'turno') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
