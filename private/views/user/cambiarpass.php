<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Cambiar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="user-form">

        <?php

         if (Yii::$app->session->has('success')){ 
        	   echo Alert::widget([
                    'options' => [
                        'class' => 'alert-success',
                    ],
                    'body' => Yii::$app->session->get('success'),
                ]);
                Yii::$app->session->remove('success');
         } ?>
           
         
    <?php
        if($mensaje != ''){
            echo '<div class="alert alert-info">';
                echo $mensaje;
            echo '</div>';
        }
    ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled'=>"disabled"]) ?>

    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Contraseña anterior') ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Contraseña nueva') ?>

    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true])->passwordInput(['value' => ''])->label('Repetir Contraseña') ?>

        

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>