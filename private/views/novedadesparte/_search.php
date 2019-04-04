<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NovedadesparteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="novedadesparte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tiponovedad') ?>

    <?= $form->field($model, 'parte') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'estadonovedad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
