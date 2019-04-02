<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;



/* @var $this yii\web\View */
/* @var $model app\models\Parte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parte-form">

    <?php $form = ActiveForm::begin([
    	'id' => 'create-update-detalle-catedra-form',
    ]); ?>

    <?php $listPreceptoria=ArrayHelper::map($precepx,'id','nombre'); 
    
    ?>

  		
	   <div style="width: 25%;">
    <?= 
$form->field($model, 'fecha')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'endDate' => "1d",
        
    ],
    
]); ?>

</div>

    
    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptoria, ['prompt'=>'Seleccionar...','style' => 'width:20%']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
