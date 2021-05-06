<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HorariogymSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horariogym-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'division') ?>

    <?= $form->field($model, 'diasemana') ?>

    <?= $form->field($model, 'horario') ?>

    <?= $form->field($model, 'docentes') ?>

    <?php // echo $form->field($model, 'repite') ?>

    <?php // echo $form->field($model, 'burbuja') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
