<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Solicitudedh */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $estadosolicitudes = ArrayHelper::map($estadosolicitudes, 'id', 'nombre');
    
?>

<div class="solicitudedh-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= 

        $form->field($model, 'estadosolicitud')->widget(Select2::classname(), [
            'data' => $estadosolicitudes,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>
    <div class="panel panel-default">
        <div class="panel-heading">Expediente</div>
        <div class="panel-body">
            <div style="width: 50%;">
                    <?= 
                        $form->field($model, 'fechaexpediente')->widget(DatePicker::classname(), [
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
            <?= $form->field($model, 'expediente')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
