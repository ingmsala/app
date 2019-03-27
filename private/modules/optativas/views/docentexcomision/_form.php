<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Docentexcomision */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        ); ?>

<?php $listComisiones=ArrayHelper::map($comisiones,'id','nombre'); ?>
<?php $listOptativas=ArrayHelper::map($optativa,'id','nombre'); ?>

<div class="docentexcomision-form">

	
    <?php $form = ActiveForm::begin(); ?>
    <label for="optativa">Optativa</label> 
    <?= Html::dropDownList('optativa', '', $listOptativas, ['disabled' => true, 'class' => 'form-control ']); ?>
    <?= $form->field($model, 'comision')->dropDownList($listComisiones, ['prompt'=>'Seleccionar...', 'disabled' => true]); ?>

    <?= 

        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listDocentes,
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
