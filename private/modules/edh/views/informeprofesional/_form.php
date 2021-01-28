<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Informeprofesional */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $areas = ArrayHelper::map($areas, 'id', 'nombre');
?>

<div class="informeprofesional-form">

    <?php $form = ActiveForm::begin(); ?>

    

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
                'options' => ['style' => 'cursor: pointer;']
                
            ]);
        ?>

    </div>

    <?= 

        $form->field($model, 'areasolicitud')->widget(Select2::classname(), [
            'data' => $areas,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>


    <div class="form-group pull-right">
    <?php

        if($origen == 'update'){
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Desea de eliminar el Informe?',
                    'method' => 'post',
                ],
            ]);
        }

    ?>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="clearfix"></div>
