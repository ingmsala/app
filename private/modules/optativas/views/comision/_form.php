<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Comision */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listOptativas=ArrayHelper::map($optativas,'id','actividad0.nombre'); ?>

<div class="comision-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'optativa')->widget(Select2::classname(), [
            'data' => $listOptativas,
            'options' => ['disabled' => 'disabled'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cupo')->textInput() ?>

    <?= $form->field($model, 'horario')->textarea(['rows' => 6]) ?> 
 
   <?= $form->field($model, 'aula')->textInput(['maxlength' => true]) ?> 

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
