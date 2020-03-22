<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas - Espacios Optativos';

?>
<div class="matricula-index">

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'responsiveWrap' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel', 
                'filename' =>Html::encode($this->title),
                'config' => [
                    'worksheet' => Html::encode($this->title),
            
                ]
            ],
            //GridView::HTML => [// html settings],
            GridView::PDF => ['label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => 'Portable Document Format'],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
            ],
        ],

        'toolbar'=>[
           
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' =>'Optativa',
                'value' => function($model){
                    return $model['actividad'];
                }
            ],

            [
                'label' =>'Comisión',
                'value' => function($model){
                    return $model['comision'];
                }
            ],

            [
                'label' =>'Optativa de:',
                'value' => function($model){
                    return 'Optativa de: '.$model['curso'].'° año';
                },
                'group' => true,  // enable grouping,
               /* 'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class*/
                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns' => [[1, 2]], // columns to merge in summary
                        'content' => [              // content to show in each summary cell
                            1 => 'Total (' . $model['curso'] . ')',
                            
                            4 => GridView::F_SUM,
                            //6 => GridView::F_SUM,
                        ],
                        'contentFormats' => [      // content reformatting for each summary cell
                            
                            5 => ['format' => 'number', 'decimals' => 0],
                            6 => ['format' => 'number', 'decimals' => 2],
                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            
                            5 => ['style' => 'text-align:right'],
                            6 => ['style' => 'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'success table-success','style' => 'font-weight:bold;']
                    ];
                },
            ],

            [
                'label' =>'Inscriptos / Cupo',
                'format' => 'raw',
                'value' => function($model){
                    return '<center>'.$model["cantidad"].' / '.$model["cupo"].Progress::widget([
                        'options' => ['class' => 'progress-warning progress-striped'],
                        'percent' => $model['cantidad']*100/$model['cupo'],
                        'label' => round($model['cantidad']*100/$model['cupo']).'%'.'</center>',
                    ]);
                    return ;
                }
            ],

            
            
            
                        
            

            
        ],
    ]); ?>
</div>
