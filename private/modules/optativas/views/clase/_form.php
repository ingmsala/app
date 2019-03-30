<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

$this->registerJs("


  $(document).ready(function() { 
            $('#hr').change(function() {
            	var hc;
            	hc = $('#hr').val() * 60 / 40;
            	$('#hc').val(hc);
            }); 
        });

");

?>


<?php $tipos=ArrayHelper::map($tiposclase,'id','nombre'); ?>

<div class="clase-form">

    <?php $form = ActiveForm::begin(); ?>

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
	        	//'maxDate'=> "+3d",
	        	
	        	

		    ],
		    'options' => [
		    	//'class' => 'awe-calendar',
		    	'style' => 'width:20%',
		    	'autocomplete' => 'off',
		    	'readOnly'=> true,
		    	
			],

	     
	   
		]) 
	?>

    <?= $form->field($model, 'tipoclase')->dropDownList($tipos, ['prompt'=>'Seleccionar...']); ?>
    <div class="panel panel-default" style="width:50%;">
		<div class="panel-heading">Convertir a hora cátedra <span data-toggle="tooltip" title="Sólo se guarda el valor de la hora cátedra" class="glyphicon glyphicon-info-sign"></span></div>
		<div class="panel-body">
	    	<label>Hora reloj</label>
	    	<?= Html::input('text', 'username','', ['id'=>'hr', 'class' => 'form-control']) ?><br>
	    	<?= $form->field($model, 'horascatedra')->textInput(['maxlength' => true, 'id'=>'hc']) ?>


		</div>
	</div>
    
    <?= $form->field($model, 'tema')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
