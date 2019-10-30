<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Acta */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listescalas=ArrayHelper::map($escalas,'id','nombre');?> 

<div class="acta-form">

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
                    //'format' => 'dd/mm/yyyy',
                    //'endDate' => "1d",
                    
                ],
            ]); 
        ?>
    </div>
    <?= $form->field($model, 'escalanota')->dropDownList($listescalas, ['prompt'=>'Seleccionar...','style' => 'width:50%'])->label('Escala de Notas'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
