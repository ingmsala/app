<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preinscripcion-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'disabled'=>(Yii::$app->user->identity->role == 4) ? 'disabled' : false]) ?>

    <?= $form->field($model, 'activo')->dropDownList($tipodepublicacion, ['prompt'=>'Seleccionar...']); ?>

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
