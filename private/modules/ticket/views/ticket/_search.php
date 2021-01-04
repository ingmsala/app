<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\TicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'hora') ?>

    <?= $form->field($model, 'asunto') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'estadoticket') ?>

    <?php // echo $form->field($model, 'agente') ?>

    <?php // echo $form->field($model, 'asignacionticket') ?>

    <?php // echo $form->field($model, 'prioridadticket') ?>

    <?php // echo $form->field($model, 'clasificacionticket') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
