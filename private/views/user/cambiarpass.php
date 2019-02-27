<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

	

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Contraseña anterior') ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Contraseña nueva') ?>

    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Repetir Contraseña') ?>

        

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>