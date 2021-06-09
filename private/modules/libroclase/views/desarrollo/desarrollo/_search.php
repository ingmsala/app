<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\DesarrolloSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="desarrollo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'aniolectivo') ?>

    <?= $form->field($model, 'catedra') ?>

    <?= $form->field($model, 'docente') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fechacreacion') ?>

    <?php // echo $form->field($model, 'fechaenvio') ?>

    <?php // echo $form->field($model, 'motivo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
