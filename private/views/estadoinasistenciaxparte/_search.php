<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstadoinasistenciaxparteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estadoinasistenciaxparte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'detalle') ?>

    <?= $form->field($model, 'estadoinasistencia') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'detalleparte') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
