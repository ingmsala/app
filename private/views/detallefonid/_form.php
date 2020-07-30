<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Detallefonid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallefonid-form">

    <?php $listtipo=[1=>'Secundarias', 2=>'Terciarias']; ?>

    <?php $form = ActiveForm::begin(['id' => 'registration-detallefonid']); ?>

    <?= $form->field($model, 'jurisdiccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denominacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'tipo')->dropDownList($listtipo, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', "name" => "btn_submit", "value" => "det"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
