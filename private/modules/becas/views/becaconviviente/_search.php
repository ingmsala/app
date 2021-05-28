<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\BecaconvivienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="becaconviviente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'apellido') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'cuil') ?>

    <?= $form->field($model, 'fechanac') ?>

    <?php // echo $form->field($model, 'nivelestudio') ?>

    <?php // echo $form->field($model, 'negativaanses') ?>

    <?php // echo $form->field($model, 'parentesco') ?>

    <?php // echo $form->field($model, 'solicitud') ?>

    <?php // echo $form->field($model, 'persona') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
