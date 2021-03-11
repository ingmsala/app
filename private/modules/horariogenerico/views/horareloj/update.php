<?php

use kartik\form\ActiveForm;
use kartik\time\TimePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Horareloj */

?>
<div class="horareloj-update">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'inicio')->widget(TimePicker::classname(), [

'pluginOptions' => [
        
        'showMeridian' => false,
        'minuteStep' => 1,
        'defaultTime' => false,

    ]

]); ?>

<?= $form->field($model, 'fin')->widget(TimePicker::classname(), [

'pluginOptions' => [
        
        'showMeridian' => false,
        'minuteStep' => 1,
        'defaultTime' => false,

    ]

]); ?>




<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
