<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoinasistenciaxparte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estadoinasistenciaxparte-form">

	<?php $listFaltas=ArrayHelper::map($faltas,'id','nombre'); ?>

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'falta')->dropDownList($listFaltas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'detalle')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
