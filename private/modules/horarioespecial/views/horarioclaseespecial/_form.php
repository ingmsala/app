<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Horarioclaseespecial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horarioclaseespecial-form">

<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
    <?php $form = ActiveForm::begin(['id' => 'horariodjform', 'options' => ['data-pjax' => true]]); ?>
    
    
    

    <?= $form->field($model, 'inicio')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99',
    ]) ?>

    <?= $form->field($model, 'fin')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99',
    ]) ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
