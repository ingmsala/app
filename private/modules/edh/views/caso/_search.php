<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\CasoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caso-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'inicio') ?>

    <?= $form->field($model, 'fin') ?>

    <?= $form->field($model, 'resolucion') ?>

    <?= $form->field($model, 'matricula') ?>

    <?php // echo $form->field($model, 'condicionfinal') ?>

    <?php // echo $form->field($model, 'estadocaso') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
