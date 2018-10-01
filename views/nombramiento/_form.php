<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nombramiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listcargos=ArrayHelper::map($cargos,'id', function($car) {
            return '('.$car['id'].') '.$car['nombre'];}
        );?>
    <?php $listdocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
    <?php $listdivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>
    <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
    <?php $listsuplentes=ArrayHelper::map($suplentes,'id', 'nombre');?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'cargo')->dropDownList($listcargos, ['prompt'=>'Seleccionar...',
        'onchange'=>'       
                        if ($(this).val()==227) {
                            $( ".field-nombramiento-division" ).show();
                        }else{
                            
                            $( ".field-nombramiento-division" ).hide();

                        }
                        $.get( "'.Url::toRoute('/cargo/gethora').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'horas').'" ).val( data );
                                

                            }
                        );

                                   

        '])->label('Cargo'); ?>

    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'docente')->dropDownList($listdocentes, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'revista')->dropDownList($listrevistas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'condicion')->dropDownList($listcondiciones, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'division')->dropDownList($listdivisiones, ['prompt'=>'Seleccionar...']); ?>

    

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
