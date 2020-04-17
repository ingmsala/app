<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alumnoxtutor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnoxtutor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alumno')->textInput() ?>

    <?= $form->field($model, 'tutor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
