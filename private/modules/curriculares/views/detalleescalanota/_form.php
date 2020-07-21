<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Detalleescalanota */
/* @var $form yii\widgets\ActiveForm */
$listescalas=ArrayHelper::map($escalas,'id', 'nombre');
$listcondiciones=ArrayHelper::map($condiciones,'id', 'nombre');

?>

<div class="detalleescalanota-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nota')->textInput(['maxlength' => true]) ?>

    <?= 

        $form->field($model, 'escalanota')->widget(Select2::classname(), [
            'data' => $listescalas,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'condicionnota')->widget(Select2::classname(), [
            'data' => $listcondiciones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
