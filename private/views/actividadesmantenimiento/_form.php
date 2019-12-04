<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Actividadesmantenimiento */
/* @var $form yii\widgets\ActiveForm */

$estadolist = ArrayHelper::map($estado, 'id', 'nombre');
?>


<div class="actividadesmantenimiento-form">

	<div class="panel panel-default">
        <?php date_default_timezone_set('America/Argentina/Buenos_Aires');?>
	  <div class="panel-body"><?=  Yii::$app->formatter->asDate($modeltarea->fecha, 'dd/MM/yyyy').': '.$modeltarea->descripcion  ?></div>
	</div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($modeltarea, 'estadotarea')->dropDownList($estadolist, ['prompt'=>'Seleccionar...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
