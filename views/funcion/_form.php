<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Funcion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="funcion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listCargos=ArrayHelper::map($cargos,'id', function($car) {
            return '('.$car['id'].') '.$car['nombre'];}
        );?>
    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->dropDownList($listCargos, ['prompt'=>'Seleccionar...',
        'onchange'=>'       
                        
                        $.get( "'.Url::toRoute('/cargo/gethora').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'horas').'" ).val( data );
                                
                            }
                        );
                        

        '])->label('Cargo'); ?>

    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'docente')->dropDownList($listDocentes, ['prompt'=>'Seleccionar...']); ?>
    
    <?= $form->field($model, 'division')->textInput() ?>

    <?= $form->field($model, 'revista')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
