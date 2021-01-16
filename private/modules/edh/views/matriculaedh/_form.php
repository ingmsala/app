<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Matriculaedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="matriculaedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alumno')->textInput() ?>

    <?= $form->field($model, 'division')->textInput() ?>

    <?= $form->field($model, 'aniolectivo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
