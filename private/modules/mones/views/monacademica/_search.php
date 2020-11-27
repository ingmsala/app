<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\MonacademicaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monacademica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'curso') ?>

    <?= $form->field($model, 'condicion') ?>

    <?= $form->field($model, 'nota') ?>

    <?= $form->field($model, 'alumno') ?>

    <?php // echo $form->field($model, 'materia') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
