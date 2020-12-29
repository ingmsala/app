<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Agentextipo */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $tipocargo=ArrayHelper::map($tipocargo,'id','nombre'); ?>

<div class="agentextipo-form">

    <h4><?= $agentex->apellido.', '.$agentex->nombre ?></h4>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipocargo')->widget(Select2::classname(), [
                'data' => $tipocargo,
                'options' => ['placeholder' => 'Seleccionar...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
