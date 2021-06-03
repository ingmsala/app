<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaalumno */
/* @var $form yii\widgets\ActiveForm */

$ocupaciones = ArrayHelper::map($ocupaciones, 'id', 'nombre');
$nivelestudio = ArrayHelper::map($nivelestudio, 'id', 'nombre');
$ayudasestatal = ArrayHelper::map($ayudasestatal, 'id', 'nombre');
$parentescos = ArrayHelper::map($parentescos, 'id', 'nombre');


?>
<div class="becaalumno-form">

    <?php

            echo FormGrid::widget([
            
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'apellido'=>['type'=>Form::INPUT_TEXT],
                        'nombre'=>['type'=>Form::INPUT_TEXT],
                        'cuil'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\yii\widgets\MaskedInput', 
                            'options'=>['mask' => '99-99999999-9',], 
                        ],
                        
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'parentesco'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$parentescos,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ], 
                            
                        ],
                        'conviviente'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>['1' => 'Sí', '2' => 'No'],
                                'options' => [
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ], 
                            
                        ],
                        'fechanac'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\date\DatePicker', 
                            'options'=>[
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                //'value' => '23-Feb-1982',
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'dd/mm/yyyy',
                                    
                                    
                                ],
                            ]
                        ],
                        'mail'=>['type'=>Form::INPUT_TEXT],   
                        
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>2</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'domicilio'=>['type'=>Form::INPUT_TEXT],
                        'telefono'=>['type'=>Form::INPUT_TEXT],
                        'nivelestudio'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$nivelestudio,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ], 
                        ],   
                    ]
                ],

                [
                    //'contentBefore'=>'<legend class="text-info"><small>3</small></legend>',
                    'attributes'=>[       // 2 column layout
                        
                        'ocupaciones'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'label' => 'Condición ocupacional <span class="text-muted" style="font-size:0.7em">(Puede seleccionar una o más)</span>', 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$ocupaciones,
                                'options' => [
                                    'placeholder' => 'Seleccionar...',
                                    'multiple' => true,
                                ]
                            ], 
                        ],
                        'ayudas'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'label' => 'Ayuda económica estatal <span class="text-muted" style="font-size:0.7em">(Puede seleccionar una o más)</span>', 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$ayudasestatal,
                                'options' => [
                                    'placeholder' => 'Seleccionar...',
                                    'multiple' => true,
                                ]
                            ], 
                            
                        ],
                        
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>3</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'image'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'label' => 'Negativa de Anses <span style="font-size:0.7em">'.Html::a('Puede solicitarla haciendo click aquí', 'https://www.anses.gob.ar/consulta/certificacion-negativa', ['target'=>'_blank']).'</span>',
                            'widgetClass'=>'\kartik\file\FileInput', 
                            'attribute' => 'image[]',
                            'options'=>[
                                'options' => [
                                    'multiple' => true,
                                    
                                ],
                                'pluginOptions' => [
                                    'overwriteInitial'=>false,
                                    'showPreview' => false,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false
                                ],
                            ], 
                        ],
                    ]
                ],

                
                
            ]

        ]);
    ?>



    

    

</div>

