<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Detalleactividadpsc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalleactividadpsc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'actividad')->textInput() ?>

    <?= $form->field($model, 'matricula')->textInput() ?>

    <?= $form->field($model, 'presentacion')->textInput() ?>

    <?= $form->field($model, 'calificacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
