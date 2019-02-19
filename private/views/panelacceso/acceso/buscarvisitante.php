<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Acceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acceso-form">

	
    <?php $form = ActiveForm::begin(); ?>
    	
    <?= $form->field($model, 'apellidos')->textInput(['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1'])->label("Buscar") ?>    

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
        

    </div>

    <?php ActiveForm::end(); ?>

    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader22'></h2>",
            'id' => 'modal22',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent22'></div>";

        Modal::end();
    ?>

</div>


