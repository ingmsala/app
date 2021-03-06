<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\ClasediariaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clasediaria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'catedra') ?>

    <?= $form->field($model, 'temaunidad') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'fechacarga') ?>

    <?php // echo $form->field($model, 'agente') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'modalidadclase') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
