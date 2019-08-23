<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nombramiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listcargos=ArrayHelper::map($cargos,'id', function($car) {
            return '('.$car['id'].') '.$car['nombre'];}
        );?>
    <?php $listdocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
    <?php $listdivisiones=ArrayHelper::map($divisiones,'id','nombre'); ?>
    <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
    <?php $listsuplentes=ArrayHelper::map($suplentes,'id', 'nombre');?>
    <?php $listextensiones=ArrayHelper::map($extensiones,'id', 'nombre');?>

    

    
    <?= 

        $form->field($model, 'cargo')->widget(Select2::classname(), [
            'data' => $listcargos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==227) {
                            document.getElementById("labeldivision").childNodes[0].nodeValue="División";
                           
                        }else{
                            
                           document.getElementById("labeldivision").childNodes[0].nodeValue="Padrón";

                        }
                        $.get( "'.Url::toRoute('/cargo/gethora').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'horas').'" ).val( data );
                                

                            }
                        );
                }',
            ]
        ]);

    ?>


    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'extension')->dropDownList($listextensiones, 
        [
            'prompt' => '(Sin extensión horaria)',
            'id' => 'dropdownextension',
        ]); ?>


    <div class="well" id="divdetres" <?php if($model->extension==null) echo 'style="display: none; margin:28px;"'; else echo 'style="display: block; margin:28px;"'; ?>>
    <?= $form->field($model, 'resolucionext')->textInput() ?>

    
    <div style="width: 25%;">
    <?= 
$form->field($model, 'fechaInicioext')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy',
        
    ],
    
]); ?>

</div>

    <div style="width: 25%;">
    <?= 
$form->field($model, 'fechaFinext')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy',
        
    ],
    
]); ?>

</div>

    </div>

    <?= 

        $form->field($model, 'docente')->widget(Select2::classname(), [
            'data' => $listdocentes,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'revista')->dropDownList($listrevistas, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'condicion')->dropDownList($listcondiciones, ['prompt'=>'Seleccionar...']); ?>

    <?= 

        $form->field($model, 'division')->widget(Select2::classname(), [
            'data' => $listdivisiones,
            'options' => ['placeholder' => '(Toda la institución)'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('División o Padrón', ['id' => 'labeldivision']);

    ?>

    <?= $form->field($model, 'resolucion')->textInput() ?>

    
    <div style="width: 25%;">
    <?= 
$form->field($model, 'fechaInicio')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy',
        
    ],
    
]); ?>

</div>

    <div style="width: 25%;">
    <?= 
$form->field($model, 'fechaFin')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy',
        
    ],
    
]); ?>

</div>    

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 

    $this->registerJs('
         $("#dropdownextension").change(function(){
            var value = this.value;
            
            if (value>0) {
                           $( "#divdetres" ).show();
                        }else{
                            
                           $( "#divdetres" ).hide();
                           $( "#'.Html::getInputId($model, 'resolucionext').'" ).val( null );
                           $( "#'.Html::getInputId($model, 'fechaInicioext').'" ).val( null );
                           $( "#'.Html::getInputId($model, 'fechaFinext').'" ).val( null );

                        }
        })'
    );

?>
