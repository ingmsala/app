<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */

$this->title = 'Asignar Suplente';
$this->params['breadcrumbs'][] = ['label' => 'Nombramientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nombramiento-asignarsuplente">


<?php $form = ActiveForm::begin(); ?>

<?php $listsuplentes=ArrayHelper::map($suplentes,'id', 'nombre');?>


<?= $form->field($model, 'nombre')->textInput(); ?>
<?= $form->field($model, 'suplente')->dropDownList($listsuplentes, ['prompt'=>'Seleccionar...']); ?>


<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>