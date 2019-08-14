<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoxnovedad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estadoxnovedad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'novedadesparte')->textInput() ?>

    <?= $form->field($model, 'estadonovedad')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
