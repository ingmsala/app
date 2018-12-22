<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-catedra-form">

    <?php $form = ActiveForm::begin([
        'id' => 'create-update-detalle-catedra-form',
        'enableAjaxValidation' => true
    ]); ?>

   <?= 
        $form->field($model, 'fechaFin')->widget(DatePicker::class, [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions'=>[
            //'changeYear' => true,
            //'changeMonth' => true,
            'showOn' => 'both',
            //'buttonImage' => '',
            'buttonImageOnly' => false,
            'buttonText'=> '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
            'maxDate'=> "+0d",
            

        ],
        'options' => [
            //'class' => 'form-control',
            'style' => 'width:20%',
            'autocomplete' => 'off',
            'readOnly'=> true,


            //'aria-describedby'=>"basic-addon1",
            
            


        ],

         
       
        ]) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>