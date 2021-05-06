<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Horariogym */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horariogym-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'division')->textInput() ?>

    <?= $form->field($model, 'diasemana')->textInput() ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'docentes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repite')->textInput() ?>

    <?= $form->field($model, 'burbuja')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
