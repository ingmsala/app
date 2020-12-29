<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Docentexdepartamento */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
    );?>
<?php $listdepartamentos=ArrayHelper::map($departamentos,'id','nombre'); ?>
<?php $listfunciones=ArrayHelper::map($funciones,'id','nombre'); ?>

<div class="docentexdepartamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'departamento')->widget(Select2::classname(), [
            'data' => $listdepartamentos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 
    

        $form->field($model, 'agente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'funciondepto')->widget(Select2::classname(), [
            'data' => $listfunciones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
