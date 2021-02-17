<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Areaticket */
/* @var $form yii\widgets\ActiveForm */

$activos=['1' => 'Activo', '2' => 'Inactivo'];

?>

<div class="areaticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= 

        $form->field($model, 'activo')->widget(Select2::classname(), [
            'data' => $activos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
