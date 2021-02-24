<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Detallesolicitudext */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallesolicitudext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'actividad')->textInput() ?>

    <?= $form->field($model, 'solicitud')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
