<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Horaxclase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horaxclase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clasediaria')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
