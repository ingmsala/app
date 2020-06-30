<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agentes que no tienen actualizado el domicilio en Mapuche';

?>
<div class="docente-index">

    
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode('Docentes que no tienen actualizado el domicilio en Mapuche'),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'condensed' => true,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode('Docentes que no tienen actualizado el domicilio en Mapuche'),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                ''

            ],
            '{export}',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'legajo',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . ((strlen($model->legajo)>6 || empty($model->legajo))  ? '#f2dede' : '')];
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'documento',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->documento)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => true,

                'editableOptions' => [
                    'header' => 'Documento', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => ['/docente/editdocumento']],
                ],
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
            [
                'label' => 'Docente',
                //'attribute' => 'apellido',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'value' => function($model){
                    return $model->apellido.', '.$model->nombre;
                }
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'domicilio',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->domicilo)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => function($model, $key, $index, $widget) {
                    return (!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA])); // do not allow editing of inactive records
                },

                'editableOptions' => [
                    'header' => 'Mail', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => ['/docente/editdocumento']],
                ],
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
                                   
            

            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{actualizar}',
                'buttons' => [
                    'actualizar' => function($url, $model, $key){
                        return Html::a(
                            '<span class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Marcar como "Actualizado" con Mapuche</span>',
                            '?r=docente/actualizarmapuche&id='.$model['id']);
                    },
                    
                ]

            ],

            
        ],
    ]); ?>


<?= GridView::widget([
        'dataProvider' => $dataProviderNo,
        'filterModel' => $searchModelNo,
        'pjax' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode('No docentes que no tienen actualizado el domicilio en Mapuche'),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'condensed' => true,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode('No docentes que no tienen actualizado el domicilio en Mapuche'),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                ''

            ],
            '{export}',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'legajo',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . ((strlen($model->legajo)>6 || empty($model->legajo))  ? '#f2dede' : '')];
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'documento',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->documento)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => true,

                'editableOptions' => [
                    'header' => 'Documento', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => ['/docente/editdocumento']],
                ],
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
            [
                'label' => 'Docente',
                //'attribute' => 'apellido',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'value' => function($model){
                    return $model->apellido.', '.$model->nombre;
                }
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'domicilio',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->domicilo)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => function($model, $key, $index, $widget) {
                    return (!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA])); // do not allow editing of inactive records
                },

                'editableOptions' => [
                    'header' => 'Mail', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => ['/nodocente/editdocumento']],
                ],
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
                                   
            

            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{actualizar}',
                'buttons' => [
                    'actualizar' => function($url, $model, $key){
                        return Html::a(
                            '<span class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Marcar como "Actualizado" con Mapuche</span>',
                            '?r=nodocente/actualizarmapuche&id='.$model['id']);
                    },
                    
                ]

            ],

            
        ],
    ]); ?>
</div>
