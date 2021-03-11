<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Horariogeneric */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horariogeneric-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catedra')->textInput() ?>

    <?= $form->field($model, 'horareloj')->textInput() ?>

    <?= $form->field($model, 'semana')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'burbuja')->textInput() ?>

    <?= $form->field($model, 'aniolectivo')->textInput() ?>

    <?= $form->field($model, 'diasemana')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
