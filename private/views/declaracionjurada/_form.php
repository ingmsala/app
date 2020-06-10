<?php


use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Declaracionjurada */
/* @var $form yii\widgets\ActiveForm */
$listtipodocumento=ArrayHelper::map($tipodocumento,'id','nombre');
$listlocalidad=ArrayHelper::map($localidad,'id','nombre');
$listprovincia=ArrayHelper::map($provincia,'id','nombre');
?>

<div class="declaracionjurada-form">
    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
    <?php

            echo FormGrid::widget([
            
            'model'=>$persona,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    'contentBefore'=>'<legend class="text-info"><small>Datos Personales</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'tipodocumento'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>['data'=>$listtipodocumento], 
                        ],
                        'documento'=>['type'=>Form::INPUT_TEXT],
                        'cuil'=>['type'=>Form::INPUT_TEXT],
                        
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'legajo'=>['type'=>Form::INPUT_TEXT],
                        'fechanac'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>['options'=>['width'=>50]]
                        ],   
                    ]
                ],
                [
                    
                    'attributes'=>[       // 2 column layout
                        'apellido'=>['type'=>Form::INPUT_TEXT],
                        'nombre'=>['type'=>Form::INPUT_TEXT],   
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'domicilio'=>['type'=>Form::INPUT_TEXT],
                        'localidad'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>['data'=>$listlocalidad], 
                        ],
                        
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'telefono'=>['type'=>Form::INPUT_TEXT],
                        'mail'=>['type'=>Form::INPUT_TEXT],   
                    ]
                ],
                
            ]

        ]);
    ?>

    
    <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
        <?php
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'actividadnooficial'=> [
                    'label' => 'En tareas o actividades no oficiales',
                    'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\switchinput\SwitchInput', 
                            'options'=>[
                                'pluginOptions' => [
                                    'onText' => 'Sí',
                                    'offText' => 'No',
                                    'offColor' => 'danger',
                                    'onColor' => 'success',
                                ],
                                'pluginEvents' => [
                                    'switchChange.bootstrapSwitch' => 'function() { 
                                        var conf = this.checked;
                                        if(conf){
                                            $("#divnooficial").show();
                                        }else{
                                            $("#divnooficial").hide();
                                        }
                                        
                                     }',
                                ],

                                
                            ]
                ],
            ]
        ]);
    ?>
        </h3>
    </div>

    <div id="divnooficial" class="panel-body" <?php if($model->actividadnooficial==0) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
    <?php
        echo FormGrid::widget([
            
            'model'=>$actividadnooficial,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    'attributes'=>[       // 2 column layout
                        
                        'empleador'=>['type'=>Form::INPUT_TEXT],
                        'lugar'=>['type'=>Form::INPUT_TEXT],
                        'sueldo'=>['type'=>Form::INPUT_TEXT],
                                                
                    ]
                ],

                [
                    'attributes'=>[       // 2 column layout
                        
                        'ingreso'=>['type'=>Form::INPUT_TEXT],
                        'funcion'=>['type'=>Form::INPUT_TEXT],
                        
                    ]
                ],
            ]
    ]);
    
    ?>
    </div>
    </div>

    
    <?= Html::button('Agregar pasividad', ['value' => Url::to('index.php?r=pasividaddj/create&dj='.$model->id), 'class' => 'btn btn-success', 'id'=>'modalaDetalleParte']) ?>
    
    <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
        <?php
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'pasividad'=> [
                    'label' => 'Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)',
                    'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\switchinput\SwitchInput', 
                            'options'=>[
                                'pluginOptions' => [
                                    'onText' => 'Sí',
                                    'offText' => 'No',
                                    'offColor' => 'danger',
                                    'onColor' => 'success',
                                ],
                                'pluginEvents' => [
                                    'switchChange.bootstrapSwitch' => 'function() { 
                                        var conf = this.checked;
                                        var estado = 0;
                                        if(conf){
                                            $("#divpasividad").show();
                                            estado = 1;
                                        }else{
                                            $("#divpasividad").hide();
                                            estado = 0;
                                        }
                                        
                                        

                                        $.ajax({
                                            url:   "index.php?r=declaracionjurada/actualizarpasividad",
                                            type:  "post",
                                            data: {id: '.$model->id.', estado: estado},
                                            
                                            error: function (xhr, status, error) {
                                              alert(error);
                                            }
                                          }).done(function (data) {
                                            
                                          });
                                        
                                     }',
                                ],
                            ]
                ],
            ]
        ]);
    ?>
        </h3>
    </div>
    <div id="divpasividad" class="panel-body" <?php if($model->pasividad==0) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
    <?php
    echo FormGrid::widget([
        
        'model'=>$pasividaddj,
        'form'=>$form,
        'autoGenerateColumns'=>true,
        'rows'=>[
            [
                'attributes'=>[       // 2 column layout
                    
                    'regimen'=>['type'=>Form::INPUT_TEXT],
                    'causa'=>['type'=>Form::INPUT_TEXT],
                    'caja'=>['type'=>Form::INPUT_TEXT],
                                            
                ]
            ],

            [
                'attributes'=>[       // 2 column layout
                    
                    'fecha'=>['type'=>Form::INPUT_TEXT],
                    'importe'=>['type'=>Form::INPUT_TEXT],
                    'percibe'=>['type'=>Form::INPUT_TEXT],
                    
                ]
            ],
        ]
]);

?>
    </div>
    </div>
    <p>Declaro bajo juramento que todos los datos consignados son veraces y exactos, de acuerdo  a mi leal saber y entender. Asimisimo, me notifico que cualquier falsedad, ocultamiento u omisión dará motivo a las más severas sanciones disciplinarias, como así también que estoy obligado a denunciar dentro de las cuarenta y ocho horas las modificaciones  que se produzcan en el futuro</p>

    
    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
