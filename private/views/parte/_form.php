<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Parte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listPreceptoria=ArrayHelper::map($precepx,'id','nombre'); ?>

  
    
    	
    		
    	
	    <?= 
	    $form->field($model, 'fecha')->widget(DatePicker::class, [
	    //'language' => 'ru',
	    'dateFormat' => 'yyyy-MM-dd',
	    'clientOptions'=>[
	    	//'changeYear' => true,
	    	//'changeMonth' => true,
	    	'showOn' => 'both',
        	//'buttonImage' => '',
        	'buttonImageOnly' => false,
        	'buttonText'=> '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
        	'maxDate'=> "+0d",
        	

	    ],
	    'options' => [
	    	//'class' => 'form-control',
	    	'style' => 'width:20%',
	    	'autocomplete' => 'off',
	    	'readOnly'=> true,


	    	//'aria-describedby'=>"basic-addon1",
	    	
	    	


	    ],

	     
	   
		]) ?>

    
    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptoria, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
