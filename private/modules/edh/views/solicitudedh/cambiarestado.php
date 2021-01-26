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
    <div style="display: none;">
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
    </div>

    
    <?php
        if($model->estadosolicitud == 3)
            echo '<h4>¿Está seguro que desea cambiar el estado de la solicitud a <b>Aceptada</b>?<br/><br/></h4>';
        else
            echo '<h4>¿Está seguro que desea cambiar el estado de la solicitud a <b>Rechadaza</b>?<br/><br/></h4>';
    ?>
    

    <div class="form-group">
        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
