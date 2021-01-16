<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Participantereunion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantereunion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'participante')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reunionedh')->textInput() ?>

    <?= $form->field($model, 'tipoparticipante')->textInput() ?>

    <?= $form->field($model, 'asistio')->textInput() ?>

    <?= $form->field($model, 'comunico')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
