<?php

use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Horariodj */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horariodj-form">
<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
    <?php $form = ActiveForm::begin(['id' => 'horariodjform', 'options' => ['data-pjax' => true]]); ?>
    
    
    

    

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

<?php /* echo $form->field($model, 'fin')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99:99',
    ])*/ ?>

   

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
