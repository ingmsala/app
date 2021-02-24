<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $tipos=ArrayHelper::map($tipos,'id','nombre'); ?>
<?php $estados=ArrayHelper::map($estados,'id','nombre'); ?>

<div class="turnoexamen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'desde')->widget(DatePicker::classname(), [
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
            $form->field($model, 'hasta')->widget(DatePicker::classname(), [
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

    <?= $form->field($model, 'tipoturno')->dropDownList($tipos, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'activo')->dropDownList($estados, ['prompt'=>'Seleccionar...']); ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
