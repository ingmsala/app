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

if($acta->estadoacta==1){
    $botones = '{eliminar}';
}else{
    $botones = '';
}


/*$docentes = $acta->comision0->docentexcomisions;

foreach ($docentes as $agente) {
    if($agente->role == 8)
        $item[] = [$agente->agente0->apellido, $agente->agente0->nombre];
}*/
?>
<div class="detalleacta-index">

    <div  class="pull-right">
            <?php 
                
                echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center>', Url::to(['printacta', 'acta_id' => $acta->id]), ['class' => 'btn btn-default']);
            ?>
    </div>

    <div  class="pull-right">
            <?php 
                
                echo $btncerrar;
            ?>
    </div>

        <div class="clearfix">
        
        </div>

        
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
                    'heading' => '<center>ACTA DE REGULARIDAD</center>',
                    //'beforeOptions' => ['class'=>'kv-panel-before'],
                    'footer' => false,
                    'bordered' => false,
                    
                    'after' => '<div class="container-fluid"><div class="row" style="text-align: center;">
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
                    return $model->matricula0->alumno0->documento;
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
                'hAlign' => 'left', 
                'vAlign' => 'middle',

               
                'value' => function($model) use($listnotas){
                    try {
                        return $listnotas[$model->detalleescala];
                    } catch (Exception $e) {
                        return '';
                    }
                    
                },


                
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
                    'visible' => false,
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
