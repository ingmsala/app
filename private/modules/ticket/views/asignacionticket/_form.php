<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Asignacionticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignacionticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agente')->textInput() ?>

    <?= $form->field($model, 'areaticket')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
