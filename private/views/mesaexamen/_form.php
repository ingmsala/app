<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $espacioslist=ArrayHelper::map($espacios,'id','nombre'); ?>
<?php $turnosexamenlist=ArrayHelper::map($turnosexamen,'id','nombre'); ?>
<?php $listactividades=ArrayHelper::map($actividades,'id','nombre'); ?>
<?php $tribunal=ArrayHelper::map($tribunal,'agente','agente'); ?>
<?php $actividadesxmesa=ArrayHelper::map($actividadesxmesa,'actividad','actividad'); ?>
<?php 
if($or == 'u')
    $listdocentes = $doce;
else
    $listdocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc->apellido.', '.$doc->nombre;}
        );
?>
<div class="mesaexamen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?php
        echo $form->field($model, 'fecha')->widget(DatePicker::classname(), [
            //'name' => 'dp_3',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //'value' => '23-Feb-1982',
            'readonly' => true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                
            ],
            
        ]); ?>
    

    <?= $form->field($model, 'hora')->widget(TimePicker::classname(), [

    'pluginOptions' => [
            
            'showMeridian' => false,
            'minuteStep' => 1,
            'defaultTime' => false,

        ]

    ]); ?>

    <?= 

        $form->field($model, 'turnoexamen')->widget(Select2::classname(), [
            'data' => $turnosexamenlist,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    

    <?php
        
        echo '<label class="control-label">Asignaturas</label>';
        echo Select2::widget([
            'name' => 'actividades',
            'data' => $listactividades,
            'value' => $actividadesxmesa,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true
            ],
        ]);

    ?>
<br />
    <?php
        
        echo '<label class="control-label">Tribunal</label>';
        echo Select2::widget([
            'name' => 'docentes',
            'data' => $listdocentes,
            'value' => $tribunal,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true
            ],
        ]);

    ?>
<br />
<?= 

$form->field($model, 'espacio')->widget(Select2::classname(), [
    'data' => $espacioslist,
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
