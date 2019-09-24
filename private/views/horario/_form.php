<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */
/* @var $form yii\widgets\ActiveForm */
$listhoras=ArrayHelper::map($horas,'id','nombre');
$listdias=ArrayHelper::map($dias,'id','nombre');
$listtipos=ArrayHelper::map($tipos,'id','nombre');
?>

<div class="horario-form">

    <?php $form = ActiveForm::begin(['id' => 'category-edit']); ?>

    <?= $form->field($model, 'diasemana')->dropDownList($listdias, 
        [
            'prompt' => 'Seleccionar...',
            
        ])->label('Día de la Semana'); ?>
    
    <?= $form->field($model, 'hora')->widget(Select2::classname(), [
            'data' => $listhoras,
            'options' => [
                'prompt' => '...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

    <?= $form->field($model, 'tipo')->dropDownList($listtipos, 
        [
            'prompt' => 'Seleccionar...',
            'class' => 'form-control'
            
        ])->label('Tipo de horario'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
