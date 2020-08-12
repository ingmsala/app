<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Detallehora */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallehora-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'clasediaria')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
