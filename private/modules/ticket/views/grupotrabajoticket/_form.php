<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Grupotrabajoticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupotrabajoticket-form">

<?php 

    $agentes=ArrayHelper::map($agentes,'id', function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );

    $areas=ArrayHelper::map($areas,'id','nombre'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'areaticket')->widget(Select2::classname(), [
            'data' => $areas,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
                'disabled' => true,
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'agente')->widget(Select2::classname(), [
            'data' => $agentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
