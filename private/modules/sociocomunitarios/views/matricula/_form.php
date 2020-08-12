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
            return $alumno['apellido'].', '.$alumno['nombre'].'('.$alumno['curso'].')';}
        ); ?>

<?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>

<?php $listEstadosMatricula=ArrayHelper::map($estadosmatricula,'id','nombre'); ?>
<?php $listComisiones=ArrayHelper::map($comisiones,'id', function($comision) {
           return $comision->espaciocurricular0->aniolectivo0->nombre.' - '.$comision->espaciocurricular0->actividad0->nombre.' - Comisión: '.$comision->nombre;}
        );?>


<div class="matricula-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= 

        $form->field($model, 'alumno')->widget(Select2::classname(), [
            'data' => $listAlumnos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'division')->widget(Select2::classname(), [
            'data' => $listDivisiones,
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
        ])->label('Proyecto Sociocomunitario');

    ?>

   

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
