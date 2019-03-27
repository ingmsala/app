<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listAlumnos=ArrayHelper::map($alumnos,'id', function($alumno) {
            return $alumno['apellido'].', '.$alumno['nombre'];}
        ); ?>

<?php $listComisiones=ArrayHelper::map($comisiones,'id','nombre'); ?>
<?php $listEstadosMatricula=ArrayHelper::map($estadosmatricula,'id','nombre'); ?>


<div class="matricula-form">

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

    <?= 

        $form->field($model, 'alumno')->widget(Select2::classname(), [
            'data' => $listAlumnos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'comision')->widget(Select2::classname(), [
            'data' => $listComisiones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'estadomatricula')->widget(Select2::classname(), [
            'data' => $listEstadosMatricula,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
