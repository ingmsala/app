<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rolexuser */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listusuarios=ArrayHelper::map($usuarios,'id','username'); ?>
<?php $listroles=ArrayHelper::map($roles,'id','nombre'); ?>

<div class="rolexuser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'user')->widget(Select2::classname(), [
            'data' => $listusuarios,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

<?= 

$form->field($model, 'role')->widget(Select2::classname(), [
    'data' => $listroles,
    'options' => ['placeholder' => 'Seleccionar...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

    <?= $form->field($model, 'subrole')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
