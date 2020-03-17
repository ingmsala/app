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
                    return $model['curso'].'°';
                }
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
