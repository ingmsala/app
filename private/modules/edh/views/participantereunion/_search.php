<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\ParticipantereunionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantereunion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'participante') ?>

    <?= $form->field($model, 'reunionedh') ?>

    <?= $form->field($model, 'tipoparticipante') ?>

    <?= $form->field($model, 'asistio') ?>

    <?php // echo $form->field($model, 'comunico') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
