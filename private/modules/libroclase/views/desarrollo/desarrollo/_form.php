<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\Desarrollo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="desarrollo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aniolectivo')->textInput() ?>

    <?= $form->field($model, 'catedra')->textInput() ?>

    <?= $form->field($model, 'docente')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'fechacreacion')->textInput() ?>

    <?= $form->field($model, 'fechaenvio')->textInput() ?>

    <?= $form->field($model, 'motivo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
