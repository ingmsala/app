<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

	<?php $listRoles=ArrayHelper::map($roles,'id','nombre'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->passwordInput(['value' => '']) ?>

    <?= $form->field($model, 'role')->dropDownList($listRoles, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'activate')->hiddenInput(['value' => 1])->label(''); ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
