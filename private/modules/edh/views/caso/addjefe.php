<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $agentes = ArrayHelper::map($agentes, 'id', function($model){
        return $model->apellido.', '.$model->nombre;
    });
    
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(['id' => 'casoform', 'enableAjaxValidation' => true]); ?>

   <?= 

        $form->field($model, 'jefe')->widget(Select2::classname(), [
            'data' => $agentes,
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
