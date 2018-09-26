<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Materia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="materia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantHoras')->textInput() ?>

    <?php $listCursos=ArrayHelper::map($cursos,'id','nombre'); ?>

    <?= $form->field($model, 'curso')->dropDownList($listCursos, ['prompt'=>'Seleccionar...']); ?>

    <?php $listPlanes=ArrayHelper::map($planes,'id','nombre'); ?>

    <?= $form->field($model, 'plan')->dropDownList($listPlanes, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
