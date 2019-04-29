<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="seguimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'descripcion')->textarea(['rows' => '8']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>