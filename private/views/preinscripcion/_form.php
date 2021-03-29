<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcion */
/* @var $form yii\widgets\ActiveForm */

$tipoespacios = ArrayHelper::map($tipoespacios, 'id','nombre');

?>

<div class="preinscripcion-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activo')->dropDownList($tipodepublicacion, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'tipoespacio')->dropDownList($tipoespacios, ['prompt'=>'Seleccionar...']); ?>

    <?= 

        $form->field($modelXcurso, 'anio')->widget(Select2::classname(), [
            'data' => $anios,
            'options' => ['placeholder' => 'Seleccionar...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
                
            ],
        ]);

    ?>
    


    <?php
        echo $form->field($model, 'inicio')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Fecha y hora de inicio'],
            'readonly' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy hh:ii'
            ]
        ]);
    ?>

<?php
        echo $form->field($model, 'fin')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Fecha y hora de fin'],
            'readonly' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy hh:ii'
            ]
        ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
