<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalleparte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listHoras=ArrayHelper::map($horas,'id','nombre'); ?>
    <?php $listFaltas=ArrayHelper::map($faltas,'id','nombre'); ?>
     

    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>

    <?= $form->field($model, 'parte')->hiddenInput(['value'=> $partes->id])->label(false) ?>

    <?= $form->field($model, 'division')->dropDownList($listDivisiones, ['prompt'=>'Seleccionar...']); ?>

    

    <?= 

        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'hora')->dropDownList($listHoras, ['prompt'=>'Seleccionar...']); ?>

   
    <?= 

        $form->field($model, 'falta')->widget(Select2::classname(), [
            'data' => $listFaltas,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==3) {
                           $( "#retaus" ).show();
                        }else{
                            
                           $( "#retaus" ).hide();

                        }
                        
                }',
            ],
        ]);

    ?>

    <div id="retaus" style="display: none;">
        <?= $form->field($model, 'llego')->textInput() ?>

        <?= $form->field($model, 'retiro')->textInput() ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
