<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    if($model->aniolectivo0->nombre <> date('Y')){
        $anio = '<span style="background-color: #c9302c; color:#FFFFFF; font-size:15pt;">'.$model->aniolectivo0->nombre.'</span>';
        $lab = 'danger';
    }else{
        $anio = $model->aniolectivo0->nombre;
        $lab = 'default';
    }
?>

<?php
    echo '<div class="panel panel-'.$lab.'">';
?>
    <div class="panel-heading"><?= $anio.' - Cátedra: '.$catedras->actividad0->nombre.' ('.$catedras->division0->nombre.')'; ?></div>
    <div class="panel-body">
    <div class="detalle-catedra-form">

        <?php $form = ActiveForm::begin([
            'id' => 'updatehorario-detalle-catedra-form',
            'enableAjaxValidation' => true
            
        ]); ?>

        
        <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
                return $doc['apellido'].', '.$doc['nombre'];}
        );?>
        
        <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
        <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
        
        <?= $form->field($model, 'catedra')->hiddenInput(['value'=> $catedras->id])->label(false) ?>

        
           
        <?= 

            $form->field($model, 'agente')->widget(Select2::classname(), [
                'data' => $listDocentes,
                'options' => ['placeholder' => 'Seleccionar...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

        ?>

        

        <?= $form->field($model, 'hora')->textInput(['value'=>($model->hora != null) ? $model->hora : $catedras->actividad0->cantHoras, 'disabled' => 'disabled']) ?>

       

    </div>
    

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

    </div></div>
