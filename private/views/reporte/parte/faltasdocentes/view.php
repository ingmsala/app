<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = $model->id;

?>
<div class="detalle-catedra-view">

    <?php $this->registerJs("document.getElementById('modalHeader').innerHTML ='".
    'Docente: '.$model->apellido.', '.$model->nombre."';", View::POS_END, 'my-options'); ?>

    
    <h3>Detalle Ausencias</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
            if ($model['falta'] == 'Recupera/Adelanta'){
                return ['class' => 'success'];
            }elseif ($model['falta'] == 'Faltó' or $model['falta'] == 'Comisión'){
                return ['class' => 'danger'];
            }
            return ['class' => 'warning'];
        },
        'columns' => [
            
            [   
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
                
            ],
            
            [
                'label' => 'Division',
                'attribute' => 'division'
            ],
            'hora',
            'llego',
            'retiro',

            [   
                'label' => 'Falta',
                'attribute' => 'falta',
                
            ],
            

            
        ],
    ]); 
    
    $arr = [];
    $com = count(array_keys(array_column($dataProvider->models, 'falta'), "Comisión"));
    $fal = count(array_keys(array_column($dataProvider->models, 'falta'), "Faltó"));
    $tar = count(array_keys(array_column($dataProvider->models, 'falta'), "Tardanza/Ret. Anticipado"));
    $rec = count(array_keys(array_column($dataProvider->models, 'falta'), "Recupera/Adelanta"));

    if ($fal!=0)
        $arr[] = ['Faltó', $fal];
    if ($com!=0)
        $arr[] = ['Comisión', $com];
    if ($tar!=0)
        $arr[] = ['Tardanza/Ret. Anticipado', $tar];
    if ($rec!=0)
        $arr[] = ['Recupera/Adelanta', $rec];
   Highcharts::widget([
        'options' => [
            'title' => ['text' => null],
            'chart' => ['renderTo' => 'modalContentGrafico'],
            'plotOptions' => [
                'pie' => [
                    'cursor' => 'pointer',
                    
                    'dataLabels' => [
                            'enabled' => true,
                            'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
                        ],
                    'showInLegend' => false,
                ],
            ],
            'credits' => [
                'enabled' => false,
            ],
            'series' => [
                [ // new opening bracket
                    'type' => 'pie',
                    'name' => 'Cantidad',
                    'data' => $arr,
                ] // new closing bracket
            ],
        ],
    ]); 

Highcharts::widget(

    [
        'scripts' => [
                
                'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                'modules/solid-gauge',
            ],
       'options'=>[
          'chart' => ['type' => 'solidgauge', 'plotBorderWidth' => 0, 'plotShadow' => false,'renderTo' => 'modalContentGrafico2'],
          'title' => ['text' => ''],
          'credits' => [
                'enabled' => false,
           ],
          'pane' => [
                'center' => ['50%', '85%'],
                'size' => '140%',
                'startAngle' => -90,
                'endAngle' => 90,
                'background' => [
                    
                    'innerRadius' => '60%',
                    'outerRadius' => '100%',
                    'shape' => 'arc'
                ]
            ],

              
          'yAxis' => [
                'stops' => [
                    [0.1, '#DF5353'], // red
                    [0.84, '#DDDF0D'], // yellow
                    [0.85, '#55BF3B'] // green
                ],
                'lineWidth' => 0,
                'minorTickInterval' => null,
                'tickAmount' => 2,
                'title' => [
                    'y' => -70
                ],
                'labels' => [
                    'y' => 16
                ],
                'min' => 0,
                'max' => 100,
                'title' => [
                    'text' => '% Horas dictadas'
                ]
            ],

            'plotOptions' => [
                'solidgauge' => [
                    'dataLabels' => [
                        'y' => 5,
                        'borderWidth' => 0,
                        'useHTML' => true
                    ]
                ]
            ],

          'series' => [
              ['name' => 'Faltas', 'data' => [rand(0, 100)]]

          ]
       ]
        ]

);

?>


    

</div>