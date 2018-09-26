<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Division */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="division-form">

    <?php $form = ActiveForm::begin(); ?>

   	<?php $listTurnos=ArrayHelper::map($turnos,'id','nombre'); ?>
   	<?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>

   	<?= $form->field($model, 'propuesta')->dropDownList($listPropuestas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'turno')->dropDownList($listTurnos, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
