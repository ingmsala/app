<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    
    $condicionesfinales=ArrayHelper::map($condicionesfinales,'id','nombre');
   
    
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(['id' => 'actualizar-form',
                            'enableAjaxValidation' => true,
                        ]); ?>

    
    <div style="width: 50%;display: none;">
        <?= 
            $form->field($model, 'inicio')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                'options' => ['style' => 'cursor: pointer;']
                
            ]);
        ?>

    </div>
    <div style="width: 50%;<?= ($ocultarfechafin == 1) ? 'display: none;' : ''; ?>">
        <?= 
            $form->field($model, 'fin')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                'options' => ['style' => 'cursor: pointer;']
                
            ]);
        ?>

    </div>

    <?= 

        $form->field($model, 'condicionfinal')->widget(Select2::classname(), [
            'data' => $condicionesfinales,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>
    



    
    

   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
