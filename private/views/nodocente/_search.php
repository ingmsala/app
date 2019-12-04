<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NodocenteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nodocente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'legajo') ?>

    <?= $form->field($model, 'apellido') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'genero') ?>

    <?php // echo $form->field($model, 'documento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
