<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Semana */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semana-form">

    <?php $listaniolectivo=ArrayHelper::map($aniolectivo,'id','nombre'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aniolectivo')->dropDownList($listaniolectivo, ['prompt'=>'Seleccionar...']); ?>

    <?=
    $form->field($model, 'inicio')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        //'endDate' => "1d",
        
    ],
    
    ]); ?>

<?=
    $form->field($model, 'fin')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        //'endDate' => "1d",
        
    ],
    ]); ?>

    <?= $form->field($model, 'publicada')->dropDownList($publicado, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
