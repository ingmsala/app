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

$this->title = 'Comparativa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matricula-index">

<?= GridView::widget([
        'dataProvider' => $dataProvidertotales,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => 'Totales',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        
        'toolbar'=>[
            
            '',
            
        ],
        'columns' => [
            
            [
                'label' =>'Total institucionales',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['institucional'];
                }
            ],
            [
                'label' =>'Virtual 2021',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['horario2021'];
                }
            ],
            [
                'label' =>'Especial 2021',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['totalespecial'];
                }
            ],
            [
                'label' =>'Total 2021',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['total'];
                }
            ],
            
            
            
            
            
        ],
    ]); ?>

<?= GridView::widget([
        'dataProvider' => $dataOtras,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => 'Actividades especiales',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        
        'toolbar'=>[
            
            '',
            
        ],
        'columns' => [
            
            [
                'label' =>'División',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['division'];
                }
            ],
            [
                'label' =>'Actividad',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['actividad'];
                }
            ],
            [
                'label' =>'Horas especiales virtuales',
                'value' => function($model){
                   // return var_dump($model);
                    return count($model['horario']);
                }
            ],
            
            
            
            
            
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => 'Detalle comparativo',
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
            
        ],

        'toolbar'=>[
            
            '{export}',
            
        ],
        'columns' => [
            
            [
                'label' =>'División',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['division'];
                }
            ],
            [
                'label' =>'Actividad',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['actividad'];
                }
            ],
            [
                'label' =>'Horas institucionales',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['horario'];
                }
            ],
            [
                'label' =>'Horas virtuales 2021',
                'value' => function($model){
                   // return var_dump($model);
                    return $model['horariogeneric'];
                }
            ],
            
            
            
            
        ],
    ]); ?>
</div>
