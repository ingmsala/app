<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Docente */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<div class="docente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listgeneros=ArrayHelper::map($generos,'id','nombre'); ?>


    <?= $form->field($model, 'legajo')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'genero')->dropDownList($listgeneros, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id'=>'modala']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
