<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Clasediaria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clasediaria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catedra')->textInput() ?>

    <?= $form->field($model, 'temaunidad')->textInput() ?>

    <?= $form->field($model, 'tipodesarrollo')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'fechacarga')->textInput() ?>

    <?= $form->field($model, 'docente')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'modalidadclase')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
