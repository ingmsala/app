<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\SeguimientodetplanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="seguimientodetplan-index">

    <p>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'bordered' => false,
        'condensed' => true,
        'summary' => false,
        'columns' => [
            
            [
                'label' => 'Fecha',
                'vAlign' => 'middle',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Descripción',
                'vAlign' => 'middle',
                'value' => function($model){
                    
                    return $model->descripcion;
                }
            ],
            
            [
                'label' => 'Plazo',
                'vAlign' => 'middle',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->plazo, 'dd/MM/yyyy');
                }
            ],
            
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [

                    'update' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to(['seguimientodetplan/update', 'id' => $model->id]),
                            'title' => 'Modificar seguimiento',
                                'class' => 'amodalplancursado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);


                    },
                    

                ]
            
            ],
        ],
    ]); ?>
</div>
