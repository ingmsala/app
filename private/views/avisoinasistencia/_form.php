<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Avisoinasistencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisoinasistencia-form">

	<?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $form = ActiveForm::begin(); ?>

    
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


    <?= 
		$form->field($model, 'desde')->widget(DatePicker::classname(), [
		    //'name' => 'dp_3',
		    'type' => DatePicker::TYPE_COMPONENT_APPEND,
		    //'value' => '23-Feb-1982',
		    'readonly' => true,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        		        
		    ],
		    
		]); ?>

    <?= 
		$form->field($model, 'hasta')->widget(DatePicker::classname(), [
		    //'name' => 'dp_3',
		    'type' => DatePicker::TYPE_COMPONENT_APPEND,
		    //'value' => '23-Feb-1982',
		    'readonly' => true,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        		        
		    ],
		    
		]); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
