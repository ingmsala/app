<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nodocente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nodocente-form">

    <?php $listgeneros=ArrayHelper::map($generos,'id','nombre'); ?>
    <?php $listcondicion=ArrayHelper::map($condicion,'id','nombre'); ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'legajo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    

    <?= $form->field($model, 'genero')->dropDownList($listgeneros, ['prompt'=>'Seleccionar...']); ?>
    <?= $form->field($model, 'condicionnodocente')->dropDownList($listcondicion, ['prompt'=>'Seleccionar...']); ?>

    

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'categorianodoc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
