<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\DetallemoduloSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallemodulo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'moduloclase') ?>

    <?= $form->field($model, 'horarioclaseespecial') ?>

    <?= $form->field($model, 'detallecatedra') ?>

    <?= $form->field($model, 'espacio') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
