<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\range\RangeInput;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Habilitacionce */
/* @var $form yii\widgets\ActiveForm */
$listdivisiones=ArrayHelper::map($divisiones,'id','nombre');

?>

<div class="habilitacionce-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 
        $form->field($model, 'fecha')->widget(DatePicker::classname(), [
            
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //'value' => '23-Feb-1982',
            'readonly' => true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                
                
            ],
            
        ]); ?>

    <?= 

        $form->field($model, 'division')->widget(Select2::classname(), [
            'data' => $listdivisiones,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Divisiones");

    ?>

    <?php
        echo '<label class="control-label">Tipo</label>';
        echo Select2::widget([
            'name' => 'tipo',
            'data' => [1 => "COVID-19", 2 => "Paro agente", 3 => "Otro"],
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
        ]);
    ?>
    <br />
    <?php
        echo '<label class="control-label">Módulos</label>';
        echo RangeInput::widget([
            'name' => 'modulos',
            'value' => 2,
            'options' => ['readonly' => true],
            'html5Container' => ['style' => 'width:350px'],
            'html5Options' => ['min' => 1, 'max' => 8],
            
        ]);
    ?>
    <br />
    <?php
        echo '<label class="control-label">Grupos</label>';
        echo RangeInput::widget([
            'name' => 'grupos',
            'value' => 3,
            'options' => ['readonly' => true],
            'html5Container' => ['style' => 'width:350px'],
            'html5Options' => ['min' => 1, 'max' => 4],
            
        ]);
    ?>

    <br />

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
