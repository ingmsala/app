<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ingresar';

?>
<div class="site-login">
    
<div class="container">
    <div class="row">
  
                    
                       

    </div>
   <div class="row">
    <div class="form_bg">
    <center><img src="assets/images/logo-encabezado.png" width="80%" /></center>
        <br />
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Usuario") ?>

            <?= $form->field($model, 'password')->passwordInput()->label("Contraseña") ?>

            

            <div class="form-group">
                <div class="col-lg-offset-0 col-lg-12">
                    <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            

        <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>
    
</div>
