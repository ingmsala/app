<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catedra-form">

    

    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>
    <?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>
    <?php $listActividades=ArrayHelper::map($actividades,'id','nombre'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelpropuesta, 'id')->dropDownList($listPropuestas, ['prompt'=>'Seleccionar...',
    'onchange'=>'       
                        $( "#'.Html::getInputId($modelpropuesta, 'nombre').'" ).val( $(this).val() );
                        $.get( "'.Url::toRoute('/actividad/xpropuesta').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'actividad').'" ).html( data );
                                
                            }
                        );
                        $.get( "'.Url::toRoute('/division/xpropuesta').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'division').'" ).html( data );
                                
                            }
                        );

        '])->label('Propuesta Formativa'); ?>

    

    
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>


    <?= $form->field($model, 'division')->dropDownList($listDivisiones, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'actividad')->dropDownList($listActividades, ['prompt'=>'Seleccionar...']); ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div>

