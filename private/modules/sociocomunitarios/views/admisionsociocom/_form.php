<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Admisionoptativa */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $listAlumnos=ArrayHelper::map($alumnos,'id', function($alumno) {
            return $alumno['apellido'].', '.$alumno['nombre'];}
        ); ?>

<?php $listaniolectivo=ArrayHelper::map($aniolectivos,'id', 'nombre'); ?>
<?php $listturno=ArrayHelper::map($turnos,'id', 'nombre'); ?>
<div class="admisionoptativa-form">

    <?php $form = ActiveForm::begin(); ?>

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

        $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
            'data' => $listaniolectivo,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'curso')->textInput() ?>
    
    <?= 

        $form->field($model, 'turno')->widget(Select2::classname(), [
            'data' => $listturno,
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
