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
    $estadoscaso=ArrayHelper::map($estadoscaso,'id','nombre');
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="width: 50%;">
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
                
            ]);
        ?>

    </div>

    <div style="width: 50%;">
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
                
            ]);
        ?>

    </div>

    <?= $form->field($model, 'resolucion')->textInput(['maxlength' => true]) ?>

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
    <?= 

        $form->field($model, 'estadocaso')->widget(Select2::classname(), [
            'data' => $estadoscaso,
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
