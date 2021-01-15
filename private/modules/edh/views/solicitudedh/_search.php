<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\SolicitudedhSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitudedh-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'areasolicitud') ?>

    <?= $form->field($model, 'caso') ?>

    <?= $form->field($model, 'demandante') ?>

    <?php // echo $form->field($model, 'estadosolicitud') ?>

    <?php // echo $form->field($model, 'tiposolicitud') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
