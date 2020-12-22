<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Ingresar';

?>
<div class="site-login">
    
<div class="container">

    <?= Alert::widget() ?>

    <?= Yii::$app->session->setFlash('info', 'Si ud. ingresaba al sistema con un usuario administrativo, ahora deberá iniciar sesión con su cuenta UNC y operar desde allí, cambiando su rol asignado.'); ?>

    <div class="row" style="margin-top: 1%;">
  
         <div class="pull-right"><?php
         if (YII_ENV_DEV) {
            echo Html::a('Ingreso administrativo', Url::to('index.php?r=site/loginadmin'));
         }
        ?></div>           
                       

    </div>
   <div class="row">
    <div class="form_bg2">
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
            <center>
            <?php
                echo Html::a('Iniciar sesión con cuenta UNC', Url::to('index.php?r=login/cas'), $options = ['class' => 'btn btn-primary'])
            ?>
            </center>
            

            

        <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>
    
</div>
