<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Temaxclase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temaxclase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clasediaria')->textInput() ?>

    <?= $form->field($model, 'temaunidad')->textInput() ?>

    <?= $form->field($model, 'tipodesarrollo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
