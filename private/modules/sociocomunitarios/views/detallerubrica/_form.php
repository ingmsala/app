<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Detallerubrica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallerubrica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'seguimiento')->textInput() ?>

    <?= $form->field($model, 'calificacionrubrica')->textInput() ?>

    <?= $form->field($model, 'rubrica')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
