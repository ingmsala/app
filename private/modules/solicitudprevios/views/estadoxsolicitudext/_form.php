<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Estadoxsolicitudext */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estadoxsolicitudext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'motivo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
