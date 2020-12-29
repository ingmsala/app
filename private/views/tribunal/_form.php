<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tribunal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tribunal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agente')->textInput() ?>

    <?= $form->field($model, 'mesaexamen')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
