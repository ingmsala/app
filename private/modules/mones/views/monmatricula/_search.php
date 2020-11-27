<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\MonmatriculaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monmatricula-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'alumno') ?>

    <?= $form->field($model, 'carrera') ?>

    <?= $form->field($model, 'certificado') ?>

    <?= $form->field($model, 'libro') ?>

    <?php // echo $form->field($model, 'folio') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
