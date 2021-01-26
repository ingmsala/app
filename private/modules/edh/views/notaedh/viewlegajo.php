<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\NotaedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="notaedh-index">

    

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Nueva nota', ['value' => Url::to(['create', 'det' => $det]), 'title' => 'Nueva nota de '.$materia,  'class' => 'btn btn-success btn-success amodalplancursado']); ?>
        <?= Html::button('<span class="glyphicon glyphicon-pencil"></span> '.'Modificar nota', ['value' => Url::to(['index', 'det' => $det]), 'title' => 'Modificar nota de '.$materia,  'class' => 'btn btn-link amodalplancursado']); ?>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        
        'columns' => [
            
            [
                'header' => 'Notas <br/> 1°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '1',
                
                
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio <br/>calificaciones<br/> 1°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '2',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => '1°<br/> Trimestral',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '3',
                
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio<br/> 1°<br/> Trimestre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '4',
                'contentOptions' => [      // content html attributes for each summary cell
                    'style' => 'background-color:#F6E5E2;',
                ],
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Notas<br/> 2°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '5',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio <br/>calificaciones<br/> 2°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '6',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => '2°<br/> Trimestral',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '7',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio <br/>2°<br/> Trimestre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '8',
                'contentOptions' => [      // content html attributes for each summary cell
                    'style' => 'background-color:#F6E5E2;',
                ],
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Notas<br/> 3°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '9',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio <br/>calificaciones<br/> 3°T',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '10',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => '3° <br/>Trimestral',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '11',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio <br/>3° <br/>Trimestre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '12',
                'contentOptions' => [      // content html attributes for each summary cell
                    'style' => 'background-color:#F6E5E2;',
                ],
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            [
                'header' => 'Promedio<br/> Final',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => '13',
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],
            
            
        ],
    ]); ?>
</div>
