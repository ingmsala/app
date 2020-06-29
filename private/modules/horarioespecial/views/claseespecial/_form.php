<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Claseespecial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claseespecial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'horarioclaseespecial')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'aula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detallecatedra')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
