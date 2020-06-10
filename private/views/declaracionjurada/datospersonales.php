<?php



use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$listtipodocumento=ArrayHelper::map($tipodocumento,'id','nombre');
$listlocalidad=ArrayHelper::map($localidad,'id','nombre');
$listprovincia=ArrayHelper::map($provincia,'id','nombre');
$this->title = 'Declaración Jurada';
?>

<h1>De los cargos y actividades  que desempeña el causante</h1>

<?php
    if($dataProviderMsj->getTotalCount() > 0){
       // echo '<div class="alert alert-danger">';
        //echo 'Motivos de rechazo de la Declaración jurada';
        echo GridView::widget([
            'dataProvider' => $dataProviderMsj,
            'summary' => false,
            'panel' => [
                'type' => GridView::TYPE_DANGER,
                'heading' => Html::encode('Motivos de rechazo de la Declaración jurada'),
                'before' => false,
                'footer' => false,
                'after' => false,
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                
                [
                    'label' => 'Fecha',
                    'attribute' => 'fecha',
                    'format' => 'raw',
                    'value' => function($model){
                       date_default_timezone_set('America/Argentina/Buenos_Aires');
                       
                       return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                    }
                ],
                'detalle:ntext',
                
            ],
        ]);
       // echo '</div>';
    }
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
                    //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'tipodocumento'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>['data'=>$listtipodocumento], 
                        ],
                        'documento'=>['type'=>Form::INPUT_TEXT],
                        'cuil'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\yii\widgets\MaskedInput', 
                            'options'=>['mask' => '99-99999999-9',], 
                        ],
                        
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'legajo'=>['type'=>Form::INPUT_TEXT],
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
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>2</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'apellido'=>['type'=>Form::INPUT_TEXT],
                        'nombre'=>['type'=>Form::INPUT_TEXT],   
                    ]
                ],

                [
                    //'contentBefore'=>'<legend class="text-info"><small>3</small></legend>',
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

    <div class="form-group">
        <div class="pull-right">
            <?= Html::submitButton('Siguiente >', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>