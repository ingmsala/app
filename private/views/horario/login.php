<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Horarios';

?>
<div class="site-login">
    
<div class="container">
   <div class="row">
    <div class="form_bg">
        <h3><?= Html::encode($this->title) ?></h3>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'legajo')->textInput(['autofocus' => true])->label("Legajo") ?>

            

            

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