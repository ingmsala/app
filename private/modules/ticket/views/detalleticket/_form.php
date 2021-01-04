<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Detalleticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalleticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ticket')->textInput() ?>

    <?= $form->field($model, 'agente')->textInput() ?>

    <?= $form->field($model, 'estadoticket')->textInput() ?>

    <?= $form->field($model, 'asignacionticket')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
