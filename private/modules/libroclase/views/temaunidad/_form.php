<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Temaunidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temaunidad-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descripcion',['inputOptions' => 

            ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']])->textInput(['maxlength' => true]) ?>

        <?php
        if($create){
        echo '<label>Separador</ label>';
        echo Html::input('text','separador','', $options=['class'=>'form-control', 'maxlength'=>2, 'style'=>'width:35px','tabindex' => '2']);
        
        echo '<label>Texto a procesar</ label>';
        echo Html::textarea('procesar','', $options=['class'=>'form-control', 'tabindex' => '3', 'rows' => '6', 'cols'=>'100']);
        }
        ?>
    <br />
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'tabindex' => '4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
