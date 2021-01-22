<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Actuacionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $lugaresactuacion = ArrayHelper::map($lugaresactuacion, 'id', 'nombre');
    $areaslist = ArrayHelper::map($areas, 'id', 'nombre');
    $areasinfo = ArrayHelper::map($areas, 'id', 'nombre');
    
?>

<div class="actuacionedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'area')->widget(Select2::classname(), [
            'data' => $areaslist,
            'options' => [
                'placeholder' => 'Seleccionar...',
                //'multiple' => true,
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                
            ]);
        ?>

    </div>

    <?= 

        $form->field($modelActores, 'persona')->widget(Select2::classname(), [
            'data' => $actores,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'lugaractuacion')->widget(Select2::classname(), [
            'data' => $lugaresactuacion,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'registro')->textarea(['rows' => 6]) ?>

    <?= 

        $form->field($modelAreainf, 'area')->widget(Select2::classname(), [
            'data' => $areasinfo,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
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
