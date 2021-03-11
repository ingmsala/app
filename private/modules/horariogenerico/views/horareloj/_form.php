<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Horareloj */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $turnos=ArrayHelper::map($turnos,'id','nombre'); 
    $horas=ArrayHelper::map($horas,'id','nombre'); 

?>

<div class="horareloj-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    echo FormGrid::widget([
            
    'model'=>$model,
    'form'=>$form,
    'autoGenerateColumns'=>true,
    'rows'=>[
        [
            //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
            'attributes'=>[       // 2 column layout
                'anio'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    
                    'widgetClass'=>'\kartik\select2\Select2', 
                    'options'=>[
                        'data'=>$anios,
                        'options' => [
                            'placeholder' => 'Seleccionar...', 
                            'id' => 'aniolectivo_id', 
                            'onchange'=>'
                                $.get("index.php?r=turno/getturnos&id="+$(this).val(), function( data ) {
                                $( "select#turnos-id" ).html( data );
                                $( "div#horas-reloj" ).html( "" );
                                });
                            '
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
                    ], 
                ],
                'turno'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    'widgetClass'=>'\kartik\select2\Select2', 
                    'options'=>[
                        'data'=>[],
                        'options' => [
                            'placeholder' => 'Seleccionar...', 
                            'id' => 'turnos-id', 
                            'onchange'=>'
                                $.get("index.php?r=horariogenerico/horareloj/porsemana&semana='.$model->semana.'&turno="+$(this).val()+"&anio="+$( "select#aniolectivo_id" ).val(), function( data ) {
                                    $( "div#horas-reloj" ).html( data );
                                
                                });
                            '
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
                    ],
                ],
                
            ]
        ],

        [
            
            'attributes'=>[       // 2 column layout
                
                'hora'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    
                    'widgetClass'=>'\kartik\select2\Select2', 
                    'options'=>['data'=>$horas,
                    'options' => [
                        'placeholder' => '...',
                        'multiple' => true,
                    ],
                    ], 
                ],

            ]
        ],

    ]

]);


    ?>




    <div class="form-group">
        <?= Html::submitButton('Generar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
