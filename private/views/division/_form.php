<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Division */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="division-form">

    <?php $form = ActiveForm::begin(); ?>

   	<?php $listTurnos=ArrayHelper::map($turnos,'id','nombre'); ?>
   	<?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>
    <?php $listPreceptorias=ArrayHelper::map($preceptorias,'id','nombre'); ?>

   	<?= $form->field($model, 'propuesta')->dropDownList($listPropuestas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'aula')->textInput() ?>
    
    <?php
        if(Yii::$app->user->identity->role == Globales::US_SUPER){
    ?>
    <?= $form->field($model, 'turno')->dropDownList($listTurnos, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptorias, ['prompt'=>'Seleccionar...']); ?>

    

    <?= $form->field($model, 'enlaceclase')->textInput() ?>

    <?php
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
