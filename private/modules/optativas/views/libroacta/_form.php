<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Libroacta */
/* @var $form yii\widgets\ActiveForm */

$listestados = ArrayHelper::map($estados, 'id', 'nombre');
$listanios = ArrayHelper::map($anios, 'id', 'nombre');
?>

<div class="libroacta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'estado')->dropDownList($listestados); ?>

    <?= $form->field($model, 'aniolectivo')->dropDownList($listanios); ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
