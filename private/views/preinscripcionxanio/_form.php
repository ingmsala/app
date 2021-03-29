<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcionxanio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preinscripcionxanio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'anio')->textInput() ?>

    <?= $form->field($model, 'preinscripcion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
