<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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

    <div style="width: 50%;">
	<?php 
	echo '<div class="input-group drp-container">';
echo DateRangePicker::widget([
    'model'=>$model,
    'attribute' => 'kvdate1',
    'useWithAddon'=>true,
    'convertFormat'=>true,
    'startAttribute' => 'datetime_start',
    'endAttribute' => 'datetime_end',
    'pluginOptions'=>[
        'locale'=>['format' => 'Y-m-d'],
    ]
]) . $addon;
		echo '<label class="control-label">Fecha</label>';
		echo DatePicker::widget([
			    'model' => $model,
			    'attribute' => 'desde',
			    'attribute2' => 'hasta',
			    'options' => ['placeholder' => 'Fecha de Inicio', 'readonly' => true,],
			    'options2' => ['placeholder' => 'Fecha de Fin', 'readonly' => true,],
			    'separator' => 'hasta',
			    'type' => DatePicker::TYPE_RANGE,
			    'form' => $form,
			    'pluginOptions' => [
			        'format' => 'dd/mm/yyyy',
			        'autoclose' => true,
		    	]
			]);
	 ?>
   	</div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
