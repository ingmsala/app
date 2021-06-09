<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catedra-form">



    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>
    <?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>
    <?php $listActividades=ArrayHelper::map($actividades,'id',function($model){
        try {
            return $model->nombre.' (Plan: '.$model->plan0->nombre.')';
        } catch (\Throwable $th) {
            return $model->nombre;
        }
        
    }); ?>

    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelpropuesta, 'id')->dropDownList($listPropuestas, ['prompt'=>'Seleccionar...', 'id' => 'propuesta-id',/*
    'onchange'=>'       
                        /*$( "#'.Html::getInputId($modelpropuesta, 'nombre').'" ).val( $(this).val() );
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

        '*/])->label('Propuesta Formativa'); ?>

    

    
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin(); ?>

   
    <?= 

        $form->field($model, 'division')->widget(DepDrop::classname(), [
            //'data' => $listDivisiones,
            'type' => DepDrop::TYPE_SELECT2,
            'options'=>['id'=>'division-id'],
                                    
                'pluginOptions'=>[
                    'depends'=>['propuesta-id'],
                    'placeholder'=>'Seleccionar',
                    'url'=>Url::to(['/division/xpropuesta'])
            ]
        ]);

    ?>

       
    <?= 

        $form->field($model, 'actividad')->widget(DepDrop::classname(), [
            'options'=>['id'=>'actividad-id'],
            'type' => DepDrop::TYPE_SELECT2,                        
            'pluginOptions'=>[
                    'depends'=>['propuesta-id'],
                    'placeholder'=>'Seleccionar',
                    'url'=>Url::to(['/actividad/xpropuesta'])
            ]
        ]);

    ?>
    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div>

