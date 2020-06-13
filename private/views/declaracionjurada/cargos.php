<?php



use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\typeahead\Typeahead;


$this->title = 'Declaración Jurada';

?>

<h1><?= Html::encode($this->title) ?></h1>
    <h4 class="text-muted">Debe completar una fila por cada cargo</h4>

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

            
            /*unset($attribs['attributes']['color']);
            $attribs['attributes']['status'] = [
                'type'=>TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\widgets\SwitchInput::classname()
            ];*/
            
            echo TabularForm::widget([
                'dataProvider'=>$dataProvider,
                'form'=>$form,
                //'staticOnly'=>true,
                'actionColumn'=>[
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{deletefuncion} ',
                    'buttons' => [
                        
                        'deletefuncion' => function($url, $model, $key){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=funciondj/delete&id='.$model['id'], 
                                ['data' => [
                                'confirm' => '¿Está seguro de querer eliminar este elemento?',
                                'method' => 'post',
                                 ]
                                ]);
                        },
                    ]
    
                ],
                'checkboxColumn'=>false,
                
                'attributes'=>[

                    'id' => [ // atributo de clave primaria 
                        'type' => TabularForm :: INPUT_HIDDEN , 
                        'columnOptions' => [ 'hidden' => true ]
                    ],
                    
                    'reparticion'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options'=>[
                            'options' => ['placeholder' => 'Repartición', "autocomplete"=>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => array_column($listadofunciones,'reparticion'),
                                    'limit' => 10
                                ]
                            ]
                        ], 
                    ],
                    'cargo'=>[
                        'type'=>TabularForm::INPUT_WIDGET, 
                        'widgetClass'=>'\kartik\typeahead\Typeahead', 
                        'options'=>[
                            'options' => ['placeholder' => 'Cargo', "autocomplete"=>"off"],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => array_column($listadofunciones,'cargo'),
                                    'limit' => 10
                                ]
                            ]
                        ], 
                    ],
                    'horas'=>[
                        'type'=>TabularForm::INPUT_TEXT,
                        'options' => ['placeholder' => 'Horas', "autocomplete"=>"off"],
                    ],

                    

                ],
                
                'gridSettings'=>[
                    //'condensed'=>true,
                    //'floatHeader'=>true,
                    'responsiveWrap' => false,
                    'summary' => false,
                    'panel'=>[
                        'heading' => 'Datos relacionados con las funciones, cargos y ocupaciones',
                        'before' => false,
                        'footer'=>false,
                        'type' => GridView::TYPE_DEFAULT,
                        'after'=> Html::submitButton('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar fila', ['class'=>'btn btn-success', 'name' => 'btn_submit', 'value' => 'add'])
                               
                                
                    ],
                    
                ]   
            ]);

            
    ?>
   
        

        <div class="form-group">
            <div class="pull-right"><?= Html::submitButton('Siguiente >', ['class' => 'btn btn-primary', 'name' => 'btn_submit', 'value' => 'sig']) ?></div>
            <div class="pull-right">&nbsp;</div>
            <div class="pull-right"><?= Html::submitButton('< Anterior', ['class' => 'btn btn-primary', 'name' => 'btn_submit', 'value' => 'ant']) ?></div>
        </div>

    <?php ActiveForm::end(); ?>

</div>