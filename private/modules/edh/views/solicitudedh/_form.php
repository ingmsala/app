<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Solicitudedh */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $areas = ArrayHelper::map($areas, 'id', 'nombre');
    $demandantes = ArrayHelper::map($demandantes, 'id', function($model){
        return $model->apellido.', '.$model->nombre.' ('.$model->parentesco.')';
    });
?>

<div class="solicitudedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'fecha')->widget(DatePicker::classname(), [
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

    <?= 

        $form->field($model, 'areasolicitud')->widget(Select2::classname(), [
            'data' => $areas,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'demandante')->widget(Select2::classname(), [
            'data' => $demandantes,
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

                    <?= $form->field($model, 'expediente')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
