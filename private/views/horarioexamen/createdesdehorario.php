<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */
/* @var $form yii\widgets\ActiveForm */
$listcatedras=ArrayHelper::map($catedras,'id',function($cat){
    $doc = '';
    foreach ($cat->detallecatedras as $dc) {
        if($dc->revista == 6){
            $doc = $dc->agente0->apellido.''.$dc->agente0->nombre;
            break;
        }
    }
    return $cat->actividad0->nombre.' - '.$doc;
});
$listhoras=ArrayHelper::map($horas,'id','nombre');

$listtipos=ArrayHelper::map($tipos,'id','nombre');
?>
<?php  
 $js=<<< JS
     $('#finddoc').select2('open');
     
JS;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= 'Asignar horario a agente de '.Html::encode($division->nombre); ?></div>
    <div class="panel-body">
<div class="horario-form">

    <?php $form = ActiveForm::begin(['id' => 'category-edit']); ?>

    <?= 
        $form->field($model, 'fecha')->widget(DatePicker::classname(), [
            //'name' => 'dp_3',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //'value' => '23-Feb-1982',
            'disabled' => 'disabled',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                'endDate' => "1d",
                
            ],
            
        ]); ?>
    
    <?= $form->field($model, 'catedra')->widget(Select2::classname(), [
            'data' => $listcatedras,
            'options' => [
                'prompt' => '...',
                'id' => 'finddoc',
                
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

     <?= $form->field($model, 'hora')->dropDownList($listhoras, 
        [
            'prompt' => 'Seleccionar...',
            'class' => 'form-control',
            'disabled' => 'disabled',
            
        ])->label('Hora'); ?>

    <?= $form->field($model, 'tipo')->dropDownList($listtipos, 
        [
            'prompt' => 'Seleccionar...',
            'class' => 'form-control',
            'disabled' => 'disabled',
            
        ])->label('Tipo de horario'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div></div>
<?php $this->registerJs($js, yii\web\View::POS_READY); ?>