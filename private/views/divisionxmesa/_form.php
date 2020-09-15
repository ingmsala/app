<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Divisionxmesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="divisionxmesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mesaexamen')->textInput() ?>

    <?= $form->field($model, 'division')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
