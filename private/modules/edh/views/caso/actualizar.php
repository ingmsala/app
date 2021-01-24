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
    
    $condicionesfinales=ArrayHelper::map($condicionesfinales,'id','nombre');
    $estadoscaso=ArrayHelper::map($estadoscaso,'id','nombre');
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(['id' => 'actualizar-form',
                            'enableAjaxValidation' => true,
                        ]); ?>

    <?= $form->field($model, 'resolucion')->textInput(['maxlength' => true]) ?>

  



    
    

   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
