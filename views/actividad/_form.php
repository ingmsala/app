<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>
    <?php $listActividadtipos=ArrayHelper::map($actividadtipos,'id','nombre'); ?>
    <?php $listPlanes=ArrayHelper::map($planes,'id','nombre'); ?>

    <?= $form->field($model, 'propuesta')->dropDownList($listPropuestas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'actividadtipo')->dropDownList($listActividadtipos, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'cantHoras')->textInput() ?>

    <?= $form->field($model, 'plan')->dropDownList($listPlanes, ['prompt'=>'Seleccionar...']); ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
