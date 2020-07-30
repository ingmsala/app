<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fonid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fonid-form">

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modaldetallefonid',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($docente, 'apellido')->textInput(['readOnly' => true]) ?>

    <?= $form->field($docente, 'nombre')->textInput(['readOnly' => true]) ?>

    <?= $form->field($docente, 'cuil')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '99-99999999-9',
    ]) ?>

    <?= $form->field($docente, 'legajo')->textInput(['readOnly' => true]) ?>

   

    <?= $this->render('cargos', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'fonid' => $fonid,
        
    ]) ?>

    <div class="well well-lg">
        DECLARO BAJO JURAMENTO QUE LOS DATOS CONSIGNADOS EN LA PRESENTE SON LOS CORRECTOS
        <br /><br />
        <div class="clearfix">
        <div class="pull-right"><?=Html::submitButton("Aceptar y enviar", ["class" => "btn btn-primary", "name" => "btn_submit", "value" => "ok"])?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
