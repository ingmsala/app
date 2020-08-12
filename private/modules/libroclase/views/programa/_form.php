<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listplanes=ArrayHelper::map($planes,'id','nombre'); ?>
<?php $listactividades=ArrayHelper::map($actividades,'id','nombre'); ?>

<div class="programa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'plan')->widget(Select2::classname(), [
            'data' => $listplanes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>
    <?= 

        $form->field($model, 'actividad')->widget(Select2::classname(), [
            'data' => $listactividades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'vigencia')->widget(Select2::classname(), [
            'data' => $vigencias,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
