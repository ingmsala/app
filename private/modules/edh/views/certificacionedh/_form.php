<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Certificacionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificacionedh-form">

<?php 
    $tiposcertificado = ArrayHelper::map($tiposcertificado, 'id', 'nombre');
    $tiposprofesional = ArrayHelper::map($tiposprofesional, 'id', 'nombre');
    
?>



    <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]);

    echo FormGrid::widget([
    
        'model'=>$model,
        'form'=>$form,
        'autoGenerateColumns'=>true,
        'rows'=>[
            [
                'attributes'=>[

                    'fecha'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\date\DatePicker', 
                        'options'=>[
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd/mm/yyyy',
                            ],
                            'options' => ['style' => 'cursor: pointer;']
                        ]
                    ],
                    'tipocertificado'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\select2\Select2', 
                        'options'=>[
                            'data'=>$tiposcertificado,
                            'options' => [
                                'placeholder' => 'Seleccionar...'],
                            //'value' => 1,
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ], 
                    ],
                    'vencimiento'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\date\DatePicker', 
                        'options'=>[
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd/mm/yyyy',
                            ],
                            'options' => ['style' => 'cursor: pointer;']
                        ]
                    ],
                    

                ]
            ],
            [
                'attributes'=>[
                    'tipoprofesional'=>[
                        'type'=>Form::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\select2\Select2', 
                        'options'=>[
                            'data'=>$tiposprofesional,
                            'options' => [
                                'placeholder' => 'Seleccionar...'],
                            //'value' => 1,
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ], 
                    ],
                    'referente'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options' => [
                            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => $referentes,
                                    'limit' => 10
                                ]
                            ]
                        ]
                    ],
                    'institucion'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options' => [
                            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => $instituciones,
                                    'limit' => 10
                                ]
                            ]
                        ]
                    ],
                ]
            ],
            [
                'attributes'=>[
                    'contacto'=>['type'=>Form::INPUT_TEXT],
                ]
            ],
            [
                    
                'attributes'=>[
                    'diagnostico'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options' => [
                            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => $diagnosticos,
                                    'limit' => 10
                                ]
                            ]
                        ]
                    ],
                ]
            ],
            [
                'attributes'=>[
                    'indicacion'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['rows'=>6]],
                ]
            ],
        ]
    ]);
    ?>
    
    <?php

        echo '<label class="control-label">Adjuntar</label>';
        echo FileInput::widget([
            'model' => $modelajuntos,
            'attribute' => 'image[]',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'overwriteInitial'=>false,
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]);

    ?>
    <br /> 

    

    

    

    

    



    
    <div class="form-group pull-right">
        <?php
        if($origen == 'update'){
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Desea de eliminar el Certificado?',
                    'method' => 'post',
                ],
            ]);
        }
              ?>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    

</div>
<div class="clearfix"></div>