<?php


use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Plancursado */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plancursado-form">

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
                'options' => ['style' => 'cursor: pointer;']
                
            ]);
        ?>

    </div>

    <?= 

        $form->field($modelCatxplan, 'catedra')->widget(Select2::classname(), [
            'data' => $catedras,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
