<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\BecaconvocatoriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="becaconvocatoria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'aniolectivo') ?>

    <?= $form->field($model, 'desde') ?>

    <?= $form->field($model, 'hasta') ?>

    <?= $form->field($model, 'becaconvocatoriaestado') ?>

    <?php // echo $form->field($model, 'becatipobeca') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
