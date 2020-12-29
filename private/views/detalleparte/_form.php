<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert alert-danger" role="alert">
     <b>Info</b> Si no se corresponde el agente en la hora seleccionada debe actualizar el horario antes de guardar la inasistencia.
    </div>

<div class="detalleparte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listHoras=ArrayHelper::map($horas,'id','nombre'); ?>
    <?php $listFaltas=ArrayHelper::map($faltas,'id','nombre'); ?>
     

    <?php $listDivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>

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

    <?= $form->field($model, 'parte')->hiddenInput(['value'=> $partes->id])->label(false) ?>

    <?php /*echo $form->field($model, 'division')->dropDownList($listDivisiones, ['prompt'=>'Seleccionar...', 'id' => 'division_id']);*/ ?>

    <?php /*
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
        ])->label($labelhora);*/

    ?>

    <?php 
/*
        $form->field($model, 'agente')->widget(Select2::classname(), [
            'data' => $listDocentes,
            'options' => ['placeholder' => 'Seleccionar...', 'readonly' => true, 'disabled' => 'disabled'],
            'pluginOptions' => [
                'allowClear' => true,

            ],
        ]);
*/
    ?>

    
    <?php echo $form->field($model, 'division')->widget(DepDrop::classname(), [
        //'type' => DepDrop::TYPE_SELECT2,
        //'name' => 'catedra',
        
        'options' => ['id' => 'division_id'],
        'pluginOptions' => [
           'depends'  => ['falta'],
           'placeholder' => 'Seleccionar...',
           'url' => Url::to(['/division/divixprec', 'preceptoria' => $partes->preceptoria])
        ]
    ]);  ?>

    <?php /*echo date("w",strtotime($partes->fecha));*/  ?>
    
                                <?php echo $form->field($model, 'agente')->widget(DepDrop::classname(), [
                                    //'type' => DepDrop::TYPE_SELECT2,
                                    //'name' => 'catedra',
                                    
                                    'options' => ['id'=>'catedra-id'],
                                    'pluginOptions' => [
                                       'depends'  => ['division_id', 'falta'],
                                       'placeholder' => 'Seleccionar...',
                                       'url' => Url::to(['/detallecatedra/docxhorario', 'diasemana' => date("w",strtotime($partes->fecha))+1, 'tipoparte' =>$partes->tipoparte])
                                    ]
                                ])->label('Docente (Materia)');  ?>

    <?php 

        if ($origen=='create')
            $labelhora = 'Horas <small><span class="text-muted">(Puede seleccionar más de una hora)</mark></small>';
        else
            $labelhora = 'Hora';

    ?>

     <?php echo $form->field($model, 'hora')->widget(DepDrop::classname(), [
        'type' => DepDrop::TYPE_SELECT2,
        //'name' => 'hora',
        
        'options' => ['id'=>'hora-id', 'multiple' => ($origen=='create') ? true : false,],
        'pluginOptions' => [
           'depends'  => ['division_id', 'catedra-id', 'falta'],
           'placeholder' => 'Seleccionar...',

           'url' => Url::to(['/horario/horaxdivisionxdocente', 'diasemana' => date("w",strtotime($partes->fecha))+1])
        ]
    ])->label($labelhora);  ?>

   

     

   
    

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
