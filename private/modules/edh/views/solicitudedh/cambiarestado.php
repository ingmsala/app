<?php

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

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
