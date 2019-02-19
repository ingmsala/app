<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Acceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acceso-form">

	
    <?php $form = ActiveForm::begin(); ?>
    	
    <?= $form->field($modelTarjeta, 'codigo')->textInput(['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1'])->label("Credencial") ?>    

    <div class="form-group">
        <?= Html::submitButton('Registrar Egreso', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>