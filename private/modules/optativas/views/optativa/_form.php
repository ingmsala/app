<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Optativa */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listActividades=ArrayHelper::map($actividades,'id','nombre'); ?>
<?php $listAniolectivo=ArrayHelper::map($aniolectivo,'id','nombre'); ?>

<div class="optativa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'actividad')->widget(Select2::classname(), [
            'data' => $listActividades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
            'data' => $listAniolectivo,
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
