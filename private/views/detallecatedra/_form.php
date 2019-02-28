<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
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

    
    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
    );?>
    
    <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
    <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
    
    <?= $form->field($model, 'catedra')->hiddenInput(['value'=> $catedras->id])->label(false) ?>

    
    <?= Html::tag('h3', 'Cátedra: '.$catedras->actividad0->nombre.' ('.$catedras->division0->nombre.')') ?>

 
    <?= 

        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'condicion')->dropDownList($listcondiciones, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'revista')->dropDownList($listrevistas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'hora')->textInput(['value'=>($model->hora != null) ? $model->hora : $catedras->actividad0->cantHoras]) ?>

    <?= $form->field($model, 'resolucion')->textInput() ?>

    
    <?= 
        $form->field($model, 'fechaInicio')->widget(DatePicker::class, [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions'=>[
            //'changeYear' => true,
            //'changeMonth' => true,
            'showOn' => 'both',
            //'buttonImage' => '',
            'buttonImageOnly' => false,
            'buttonText'=> '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
            
            

        ],
        'options' => [
            //'class' => 'form-control',
            'style' => 'width:20%',
            'autocomplete' => 'off',
            'readOnly'=> true,


            //'aria-describedby'=>"basic-addon1",
            
            


        ],

         
       
        ]) ?>

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
