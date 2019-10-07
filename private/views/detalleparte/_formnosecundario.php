<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert alert-info" role="alert">
     <b>Nuevo</b> Se pueden marcar horas vacantes dejando el campo de "Docente" vacío y en "Tipo de Falta" marcar la opción "Hora vacante"
    </div>

<div class="detalleparte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listHoras=ArrayHelper::map($horas,'id','nombre'); ?>
    <?php $listFaltas=ArrayHelper::map($faltas,'id','nombre'); ?>
     

    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>

    <?= $form->field($model, 'parte')->hiddenInput(['value'=> $partes->id])->label(false) ?>

    <?= $form->field($model, 'division')->dropDownList($listDivisiones, ['prompt'=>'Seleccionar...']); ?>

    
    <?= 
        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

   

     <?php 
        if ($origen=='create')
            $labelhora = 'Horas <small><span class="text-muted">(Puede seleccionar más de una hora)</mark></small>';
        else
            $labelhora = 'Hora';
        echo $form->field($model, 'hora')->widget(Select2::classname(), [
            'data' => $listHoras,
            'options' => [
                'prompt' => '...',
                'multiple' => ($origen=='create') ? true : false,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label($labelhora);
    ?>

   
    <?= 
        $form->field($model, 'falta')->widget(Select2::classname(), [
            'data' => $listFaltas,
            'options' => ['placeholder' => 'Seleccionar...', 'id'=>'falta'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==3) {
                           $( "#retaus" ).show();
                           $( "#adelrecup" ).hide();
                           $( "#'.Html::getInputId($model, 'llego').'" ).val(null);
                           $( "#'.Html::getInputId($model, 'retiro').'" ).val(null);
                           $( "#'.Html::getInputId($model, 'detalleadelrecup').'" ).val(null);
                        }else{
                            
                           $( "#retaus" ).hide();
                           $( "#'.Html::getInputId($model, 'llego').'" ).val(null);
                           $( "#'.Html::getInputId($model, 'retiro').'" ).val(null);
                           $( "#'.Html::getInputId($model, 'detalleadelrecup').'" ).val(null);
                           if ($(this).val()==6 || $(this).val()==7) {
                               $( "#adelrecup" ).show();
                               $( "#'.Html::getInputId($model, 'detalleadelrecup').'" ).val(null);
                           
                            }else{
                                
                               $( "#adelrecup" ).hide();
                               $( "#'.Html::getInputId($model, 'detalleadelrecup').'" ).val(null);
                               
                        }
                        }
                    
                        
                }',
            ],
        ]);
    ?>

    <div id="retaus" style="display: none;">
        <?= $form->field($model, 'llego')->textInput(['id'=>'llego']) ?>

        <?= $form->field($model, 'retiro')->textInput(['id'=>'retiro']) ?>
    </div>
    <div id="adelrecup" style="display: none;">
        <?= $form->field($model, 'detalleadelrecup')->textInput(['id'=>'detalleadelrecup']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>