<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas - Espacios Optativos';
$this->params['breadcrumbs'][] = $this->title;
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
            
            [
                'label' =>'Estudiante',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['estudiante'];
                }
            ],
            [
                'label' =>'Superposición',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    foreach ($model['superpuestos'] as $key => $value) {
                        $salida .= '<li>'.$value.'</li>';
                    }
                   
                   $salida .= '</ul>';
                    return $salida;
                }
            ],
            
            
            
        ],
    ]); ?>
</div>
