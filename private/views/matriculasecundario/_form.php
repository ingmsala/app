<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Matriculasecundario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="matriculasecundario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alumno')->textInput() ?>

    <?= $form->field($model, 'aniolectivo')->textInput() ?>

    <?= $form->field($model, 'division')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
