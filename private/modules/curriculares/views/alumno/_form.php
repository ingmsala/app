<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Alumno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento')->textInput() ?>

    <?= $form->field($model, 'curso')->textInput() ?>

    <?= $form->field($model, 'fechanac')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
	    'type' => DatePicker::TYPE_COMPONENT_APPEND,
	    //'value' => '23-Feb-1982',
	    'readonly' => true,
	    'pluginOptions' => [
	        'autoclose'=>true,
	        'format' => 'yyyy-mm-dd',
	        'endDate' => "1d",
	        
	    ],
    
		]);
	?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
