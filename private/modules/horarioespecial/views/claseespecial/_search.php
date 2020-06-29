<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\ClaseespecialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claseespecial-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'horarioclaseespecial') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'aula') ?>

    <?= $form->field($model, 'detallecatedra') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
