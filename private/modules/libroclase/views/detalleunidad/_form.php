<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Detalleunidad */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listunidades=ArrayHelper::map($unidades,'id','nombre'); ?>

<div class="detalleunidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'unidad')->widget(Select2::classname(), [
            'data' => $listunidades,
            'disabled' => !$multiple,
            'options' => [
                'placeholder' => '...',
                'multiple' => $multiple,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                
            ],
        ]);

    ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
