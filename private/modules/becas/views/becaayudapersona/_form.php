<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaayudapersona */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="becaayudapersona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'persona')->textInput() ?>

    <?= $form->field($model, 'ayuda')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
