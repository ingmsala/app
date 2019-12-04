<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tareamantenimiento */
/* @var $form yii\widgets\ActiveForm */
$prioridadlist = ArrayHelper::map($prioridad, 'id', 'nombre');
$estadolist = ArrayHelper::map($estado, 'id', 'nombre');
$nodocenteslist = ArrayHelper::map($nodocentes, 'id', function($model){
	return $model->apellido.', '.$model->nombre;

});

?>

<div class="tareamantenimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prioridadtarea')->dropDownList($prioridadlist, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'responsable')->widget(Select2::classname(), [
            'data' => $nodocenteslist,
            'options' => [
                'prompt' => 'Toda el Área de Mantenimiento',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

    
    <?= $form->field($model, 'estadotarea')->dropDownList($estadolist, ['prompt'=>'Seleccionar...', 'disabled' => 'disabled']); ?>

   
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
