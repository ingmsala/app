<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Calificacionrubrica */
/* @var $form yii\widgets\ActiveForm */

$listdetalleescalas=ArrayHelper::map($detalleescalas,'id', 'nota');

?>

<div class="calificacionrubrica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'detalleescalanota')->widget(Select2::classname(), [
            'data' => $listdetalleescalas,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
