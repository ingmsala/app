<?php

use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Horariocontraturno */
/* @var $form yii\widgets\ActiveForm */
$catedras=ArrayHelper::map($catedras,'id',function($cat) {
    return $cat->actividad0->nombre;
});
$dias=ArrayHelper::map($dias,'id','nombre');
$agentes=ArrayHelper::map($agentes,'id',function($model){
    return $model->getNombreCompleto();
});


?>

<div class="horariocontraturno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'diasemana')->dropDownList($dias, 
        [
            'prompt' => 'Seleccionar...',
            
            
        ])->label('Día de la Semana'); ?>

    <?= $form->field($model, 'inicio')->widget(TimePicker::classname(), [

    'pluginOptions' => [
            
            'showMeridian' => false,
            'minuteStep' => 1,
            'defaultTime' => false,

        ]

    ]); ?>

    <?= $form->field($model, 'fin')->widget(TimePicker::classname(), [

    'pluginOptions' => [
            
            'showMeridian' => false,
            'minuteStep' => 1,
            'defaultTime' => false,

        ]

    ]); ?>
    
    <?= $form->field($model, 'catedra')->widget(Select2::classname(), [
            'data' => $catedras,
            'options' => [
                'prompt' => '...',
                'id' => 'finddoc',
                
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]); ?>

    <?= $form->field($model, 'agente')->widget(Select2::classname(), [
            'data' => $agentes,
            'options' => [
                'prompt' => '...',
                
                
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]); ?>



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
