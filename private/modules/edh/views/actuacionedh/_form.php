<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Actuacionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $lugaresactuacion = ArrayHelper::map($lugaresactuacion, 'id', 'nombre');
    $areaslist = ArrayHelper::map($areas, 'id', 'nombre');
    $areasinfo = ArrayHelper::map($areas, 'id', 'nombre');
    
?>

<div class="actuacionedh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        FormGrid::widget([
        
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
                        'lugaractuacion'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$lugaresactuacion,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'],
                                //'value' => 1,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ], 
                        ],
                        'area'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$areaslist,
                                'options' => [
                                    'placeholder' => 'Seleccionar...'],
                                //'value' => 1,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ], 
                        ],

                    ]
                ],
                
            ]
        ]);

        

    ?>
    
    <?= 

        $form->field($modelActores, 'persona')->widget(Select2::classname(), [
            'data' => $actores,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    
    <?= $form->field($model, 'registro')->textarea(['rows' => 6]) ?>

    <?= 

        $form->field($modelAreainf, 'area')->widget(Select2::classname(), [
            'data' => $areasinfo,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
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
