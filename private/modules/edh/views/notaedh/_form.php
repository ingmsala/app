<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Notaedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notaedh-form">

    <?php 
        $tiposnota = ArrayHelper::map($tiposnota, 'id', 'nombre');
        $trimestres = ArrayHelper::map($trimestres, 'id', function($model){
            return str_replace('Trimestral', 'Trimestre', $model->nombre);
        });
        
    ?>

<?= Html::button('< Volver', ['value' => Url::to(['viewlegajo', 'det' => $model->detalleplancursado]), 'title' => 'Notas de '.$model->detalleplancursado0->catedra0->actividad0->nombre,  'class' => 'btn btn-primary amodalplancursado']); ?>
<br />
<br />
    <?php $form = ActiveForm::begin(); ?>

    
    <?= 

        $form->field($model, 'trimestre')->widget(Select2::classname(), [
            'data' => $trimestres,
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

        $form->field($model, 'tiponota')->widget(Select2::classname(), [
            'data' => $tiposnota,
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'nota')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p>
        
    </p>

</div>
