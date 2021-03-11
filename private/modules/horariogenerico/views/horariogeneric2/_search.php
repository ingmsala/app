<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\HorariogenericSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horariogeneric-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'catedra') ?>

    <?= $form->field($model, 'horareloj') ?>

    <?= $form->field($model, 'semana') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'burbuja') ?>

    <?php // echo $form->field($model, 'aniolectivo') ?>

    <?php // echo $form->field($model, 'diasemana') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
