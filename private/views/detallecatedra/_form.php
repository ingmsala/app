<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-catedra-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
    );?>
    
    <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
    <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
    
    <?= $form->field($model, 'catedra')->hiddenInput(['value'=> $catedras->id])->label(false) ?>

    
    <?= Html::tag('h3', 'Cátedra: '.$catedras->actividad0->nombre.' ('.$catedras->division0->nombre.')') ?>

       
    

    <?= $form->field($model, 'docente')->dropDownList($listDocentes, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'condicion')->dropDownList($listcondiciones, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'revista')->dropDownList($listrevistas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'resolucion')->textInput() ?>

    <?= $form->field($model, 'fechaInicio')->textInput() ?>

    <?= $form->field($model, 'fechaFin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
