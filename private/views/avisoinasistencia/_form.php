<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Avisoinasistencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisoinasistencia-form">

	<?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $form = ActiveForm::begin(); ?>

        
	<?php 

		
		//echo '<div class="input-group drp-container">';
		echo $form->field($model, 'hasta', [
		    'addon'=>['prepend'=>['content'=>'<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>']],
		    'options'=>['class'=>'drp-container form-group']
		])->widget(DateRangePicker::classname(), [
		    'useWithAddon'=>true,
		    'convertFormat'=>true,
		    'startAttribute' => 'desde',
    		'endAttribute' => 'hasta',
    		'readonly' => true,
		    'pluginOptions'=>[
		        'locale'=>[
		            'format'=>'d/m/yy',
		            'separator'=>' hasta el ',
		        ],
		        'opens'=>'left'
		    ],
		    
		])->label('Fecha');
		//echo '</div>';

		
	 ?>
   	
    <?= 

        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>



    <br />
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
