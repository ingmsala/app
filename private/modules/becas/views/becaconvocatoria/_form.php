<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaconvocatoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="becaconvocatoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aniolectivo')->textInput() ?>

    <?= $form->field($model, 'desde')->textInput() ?>

    <?= $form->field($model, 'hasta')->textInput() ?>

    <?= $form->field($model, 'becaconvocatoriaestado')->textInput() ?>

    <?= $form->field($model, 'becatipobeca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
