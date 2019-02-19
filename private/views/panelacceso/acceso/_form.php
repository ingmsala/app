<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Acceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acceso-form">

	<div class="row">
      <div class="col-md-6">
      	
      <?php $form = ActiveForm::begin(); ?>

      <?php $listArea=ArrayHelper::map($areas,'id','nombre'); ?>

	    <?= $form->field($model, 'visitante')->hiddenInput(['value' => $id,])->label(false) ?>

      <?= Html::label('DNI') ?>
  		<?= Html::textInput('',$dni,['class' => 'form-control', 'disabled' => true]) ?>

  		<?= Html::label('Apellidos') ?>
  		<?= Html::textInput('',$apellidos,['class' => 'form-control', 'disabled' => true]) ?>

  		<?= Html::label('Nombres') ?>
  		<?= Html::textInput('',$nombres,['class' => 'form-control', 'disabled' => true]) ?>

  		
      <?= $form->field($model, 'area')->dropDownList($listArea, ['prompt'=>'Seleccionar...']); ?>

      
      <?= $form->field($modelTarjeta, 'codigo')->textInput(['autofocus' => 'autofocus', 'class' => 'form-control', ])->label('Credencial') ?>

	  

    

    <div class="form-group">
        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

      	
      </div>
     


      <div class="col-md-6"></div>
    </div>
    
</div>
