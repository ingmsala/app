<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listAlumnos=ArrayHelper::map($alumnos,'id', function($alumno) {
            return $alumno['apellido'].', '.$alumno['nombre'];}
        ); ?>

<?php $listComisiones=ArrayHelper::map($comisiones,'id','nombre'); ?>
<?php $listEstadosMatricula=ArrayHelper::map($estadosmatricula,'id','nombre'); ?>
<?php $listComisiones=ArrayHelper::map($comisiones,'id', function($comision) {
           return $comision->optativa0->aniolectivo0->nombre.' - '.$comision->optativa0->actividad0->nombre.' - Comisión: '.$comision->nombre;}
        );?>


<div class="matricula-form">

    <?php $form = ActiveForm::begin(); ?>


<div style="width: 20%;">
    <?= 
$form->field($model, 'fecha')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        
    ],
    
]); ?>

</div>

    <?= 

        $form->field($model, 'alumno')->widget(Select2::classname(), [
            'data' => $listAlumnos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'comision')->widget(Select2::classname(), [
            'data' => $listComisiones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'estadomatricula')->widget(Select2::classname(), [
            'data' => $listEstadosMatricula,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
