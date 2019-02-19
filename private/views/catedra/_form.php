<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catedra-form">



    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>
    <?php $listPropuestas=ArrayHelper::map($propuestas,'id','nombre'); ?>
    <?php $listActividades=ArrayHelper::map($actividades,'id','nombre'); ?>

    <?php 

    echo var_dump($listActividades);
    ?>

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

   
    <?= 

        $form->field($model, 'division')->widget(Select2::classname(), [
            //'data' => $listDivisiones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>
    
    <?= 

        $form->field($model, 'actividad')->widget(Select2::classname(), [
            //'data' => $listActividades,
            'options' => ['placeholder' => 'Seleccionar...'],
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
<div>

