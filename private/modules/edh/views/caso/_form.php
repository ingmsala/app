<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $aniolectivos = ArrayHelper::map($aniolectivos, 'id', 'nombre');
    $areas = ArrayHelper::map($areas, 'id', 'nombre');
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(['id' => 'casoform', 'enableAjaxValidation' => true]); ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'inicio')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                
            ]);
        ?>

</div>

    <?= $form->field($model, 'resolucion')->textInput(['maxlength' => true]) ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= 

                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                    'data' => $aniolectivos,
                    'options' => ['placeholder' => 'Seleccionar...', 'id' => 'aniolectivo_id', 
                    
                        'onchange'=>'
                            $.get("index.php?r=edh/caso/matriculas&id="+$(this).val(), function( data ) {
                            $( "select#matricula-id" ).html( data );
                            $( "select#demandante-id" ).html( "<option>Seleccionar...</option>" );
                            });
                        '
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        
                    ],
                ]);

            ?>

            <?= 

            $form->field($model, 'matricula')->widget(Select2::classname(), [
                'data' => [],
                'options' => ['placeholder' => 'Seleccionar...', 'id' => 'matricula-id', 
                
                    'onchange'=>'
                    $.get("index.php?r=edh/caso/demandantes&id="+$(this).val(), function( data ) {
                        $( "select#demandante-id" ).html( data );
                        
                        });
                    '
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    
                ],
            ]);

            ?>

            <?= 

            $form->field($modelSolicitud, 'demandante')->widget(Select2::classname(), [
                'data' => [],
                'options' => ['placeholder' => 'Seleccionar...', 'id' => 'demandante-id'],
                'pluginOptions' => [
                    'allowClear' => true,
                    
                ],
            ]);

            ?>

            
        </div>
    </div>

    <?= 

        $form->field($modelSolicitud, 'areasolicitud')->widget(Select2::classname(), [
            'data' => $areas,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
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
