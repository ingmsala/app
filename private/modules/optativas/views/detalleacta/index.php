<?php

use app\config\Globales;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\DetalleactaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$listnotas = ArrayHelper::map($detalleescalas, 'id', 'nota');

if($acta->estadoacta==221){
    $botones = '{eliminar}';
}else{
    $botones = '';
}


/*$docentes = $acta->comision0->docentexcomisions;

foreach ($docentes as $docente) {
    if($docente->role == 8)
        $item[] = [$docente->docente0->apellido, $docente->docente0->nombre];
}*/
?>
<div class="detalleacta-index">

    
        
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pjax' => true,
        'options' => ['style' => 'font-size:11px;'],
        'condensed' => true,
        'hover' => true,
        'toolbar'=>[
                    
                    
                    
                ],

        'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => 'ACTA DE REGULARIDAD',
                    //'beforeOptions' => ['class'=>'kv-panel-before'],
                    'footer' => false,
                    'bordered' => false,
                    
                    'after' => '<div id="foot" class="container-fluid"><div class="row" style="text-align: center;">
                                    <div class="col-xs-3">
                                        <center>
                                            Aprobado <br />
                                            '.$zAprobados.'
                                        </center>
                                        
                                    </div>
                                    <div class="col-xs-3">
                                        <center>
                                            Regular <br />
                                            '.$zRegulares.'
                                        </center>
                                    </div>
                                    <div class="col-xs-3">
                                        <center>
                                            Libre <br />
                                            '.$zLibres.'
                                        </center>
                                    </div>
                                </div></div>',
                ],

        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Documento',
                'vAlign' => 'middle',
                'value' => function($model){
                    return $model->matricula0->alumno0->dni;
                }
            ],

            [
                'label' => 'Alumno',
                'vAlign' => 'middle',
                'value' => function($model){
                    return $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;
                }
            ],

            [
                'label' => 'Fecha',
                'vAlign' => 'middle',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->acta0->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Nota',
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'detalleescala',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->detalleescala)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => function($model, $key, $index, $widget) {
                    return (!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_PRECEPTOR]) || $model->acta0->estadoacta!=1); // do not allow editing of inactive records
                },

                'refreshGrid' => true,
                'value' => function($model) use($listnotas){
                    try {
                        return $listnotas[$model->detalleescala];
                    } catch (Exception $e) {
                        return '';
                    }
                    
                },

                'editableOptions' => [
                    'header' => 'Nota', 
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'formOptions' => ['action' => ['detalleacta/editdetalleacta']],
                    'data'=>$listnotas, // any list of values
                    'options' => ['class'=>'form-control', 'prompt'=>'Seleccione una nota...'],
                    'valueIfNull' =>"(cargar)",
                    'displayValueConfig' => $listnotas,
                    /*'pluginEvents' => [

                        'editableSuccess' => "$.pjax.reload('#resumencondiciones')",

                    ],*/
                ],

                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],

            [
                'label' => 'Observaciones',
                'class' => 'kartik\grid\EditableColumn',
                
                'attribute' => 'descripcion',
                

                'readonly' => function($model, $key, $index, $widget) {
                    return (!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_PRECEPTOR]) || $model->acta0->estadoacta!=1); // do not allow editing of inactive records
                },

                'editableOptions' => [
                    'header' => 'Observaciones', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
                    'formOptions' => ['action' => ['detalleacta/editdetalleacta']],
                    
                    'options' => [
                        'class'=>'form-control',
                        'rows'=>5, 
                        //'style'=>'width:400px', 
                        'placeholder'=>'Observaciones...'
                    ],
                    'valueIfNull' =>"(cargar)",
                    
                ],

                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
            
            [
                'label' => 'Condición',
                'vAlign' => 'middle',
                'value' => function($model){
                    try {
                        return $model->detalleescala0->condicionnota0->nombre;
                    } catch (Exception $e) {
                        return '';
                    }
                    
                }
            ],
            
            [
                    'class' => 'kartik\grid\ActionColumn',
                    
                    'template' => $botones,
                    
                    'buttons' => [

                        'eliminar' => function($url, $model, $key) use ($acta){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=optativas/detalleacta/delete&id='.$model->id, 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },
                        
                        
                        
                        
                    ]

            ],
        ],
    ]); ?>

</div>
