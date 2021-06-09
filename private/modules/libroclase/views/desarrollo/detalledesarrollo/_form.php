<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\Detalledesarrollo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalledesarrollo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'temaunidad')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'desarrollo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
