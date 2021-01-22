<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\ActuacionedhSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actuacionedh-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'area') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'lugaractuacion') ?>

    <?= $form->field($model, 'registro') ?>

    <?php // echo $form->field($model, 'fechacreate') ?>

    <?php // echo $form->field($model, 'agente') ?>

    <?php // echo $form->field($model, 'tipoactuacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
