<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Parte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listPreceptoria=ArrayHelper::map($precepx,'id','nombre'); ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptoria, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
