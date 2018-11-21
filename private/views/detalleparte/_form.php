<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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

    <?= $form->field($model, 'docente')->dropDownList($listDocentes, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'hora')->dropDownList($listHoras, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'llego')->textInput() ?>

    <?= $form->field($model, 'retiro')->textInput() ?>

    <?= $form->field($model, 'falta')->dropDownList($listFaltas, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
