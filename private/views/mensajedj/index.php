<?php

use kartik\grid\GridView;
use yii\helpers\Html;





    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],

            'detalle:ntext',
            
            
        ],
    ]); ?>
