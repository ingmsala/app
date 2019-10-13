<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */
/* @var $form yii\widgets\ActiveForm */
$listcatedras=ArrayHelper::map($catedras,'id',function($cat){
    $doc = 'VACANTE';
    foreach ($cat->detallecatedras as $dc) {
        if($dc->revista == 6){
            $doc = $dc->docente0->apellido.', '.$dc->docente0->nombre;
            break;
        }
    }
    return $cat->actividad0->nombre.' - '.$doc;
});
$listhoras=ArrayHelper::map($horas,'id','nombre');
$listdias=ArrayHelper::map($dias,'id','nombre');
$listtipos=ArrayHelper::map($tipos,'id','nombre');
?>
<?php  
 $js=<<< JS
     $('#finddoc').select2('open');
     
JS;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= 'Modificar docente de '.Html::encode($division->nombre); ?></div>
    <div class="panel-body">
<div class="horario-form">

    <?php $form = ActiveForm::begin(['id' => 'category-edit']); ?>

    <?= $form->field($model, 'diasemana')->dropDownList($listdias, 
        [
            'prompt' => 'Seleccionar...',
            'disabled' => 'disabled',
            
        ])->label('Día de la Semana'); ?>
    
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

    <?= $form->field($model, 'hora')->widget(Select2::classname(), [
            'data' => $listhoras,
            'options' => [
                'prompt' => '...',
                
                //'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'disabled' => 'disabled',
            ],
        ]); ?>

    <?= $form->field($model, 'tipo')->dropDownList($listtipos, 
        [
            'prompt' => 'Seleccionar...',
            'class' => 'form-control',
            'disabled' => 'disabled',
            
        ])->label('Tipo de horario'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Eliminar horario', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Está seguro de querer eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

    

</div></div></div>

<?php $this->registerJs($js, yii\web\View::POS_READY); ?>