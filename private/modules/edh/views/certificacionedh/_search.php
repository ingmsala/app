<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\CertificacionedhSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificacionedh-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'contacto') ?>

    <?= $form->field($model, 'diagnostico') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'indicacion') ?>

    <?php // echo $form->field($model, 'institucion') ?>

    <?php // echo $form->field($model, 'referente') ?>

    <?php // echo $form->field($model, 'solicitud') ?>

    <?php // echo $form->field($model, 'tipocertificado') ?>

    <?php // echo $form->field($model, 'tipoprofesional') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
