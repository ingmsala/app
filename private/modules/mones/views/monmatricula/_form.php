<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monmatricula */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monmatricula-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'alumno')->textInput() ?>

    <?= $form->field($model, 'carrera')->textInput() ?>

    <?= $form->field($model, 'certificado')->textInput() ?>

    <?= $form->field($model, 'libro')->textInput() ?>

    <?= $form->field($model, 'folio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
