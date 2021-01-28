<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Matriculaedh */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $alumnos = ArrayHelper::map($alumnos, 'id', function($model){
        return $model->nombrecompleto;
    });
    $divisiones = ArrayHelper::map($divisiones, 'id', 'nombre');
    $aniolectivos = ArrayHelper::map($aniolectivos, 'id', 'nombre');
?>

<div class="matriculaedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'alumno')->widget(Select2::classname(), [
            'data' => $alumnos,
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'division')->widget(Select2::classname(), [
            'data' => $divisiones,
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
            'data' => $aniolectivos,
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
            //'value' => 1,
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
