<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\InformeprofesionalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="informeprofesional-index">

    <p style="margin-top:1em" class="pull-right">
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar informe', ['value' => Url::to('index.php?r=edh/informeprofesional/create&solicitud='.$solicitud), 'class' => 'btn btn-success amodalinfoprofesional']); ?>
    </p> 

    <div class="clearfix"></div>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'summary' => false,
        'bordered' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'vAlign' => 'middle', 
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    
                    return Html::button(Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy'),
                            ['value' => Url::to(['informeprofesional/update', 'id' => $model->id]),
                                'class' => 'amodalinfoprofesional btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                }
            ],
            [
                'label' => 'Área',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'format' => 'raw',
                'value' => function($model){
                    return Html::button($model->areasolicitud0->nombre,
                            ['value' => Url::to(['informeprofesional/update', 'id' => $model->id]),
                                'class' => 'amodalinfoprofesional btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                }
            ],
            [
                'label' => 'Creado por',
                'vAlign' => 'middle', 
                'format' => 'raw',
                'value' => function($model){
                    return Html::button($model->agente0->apellido.', '.$model->agente0->nombre,
                            ['value' => Url::to(['informeprofesional/update', 'id' => $model->id]),
                                'class' => 'amodalinfoprofesional btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                }
            ],
            
            [
                'label' => 'Descripción',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function ($model){
                    return Html::button($model->descripcion,
                            ['value' => Url::to(['informeprofesional/update', 'id' => $model->id]),
                                'class' => 'amodalinfoprofesional btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                }

            ],

            /*[
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [

                    'update' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to(['informeprofesional/update', 'id' => $model->id]),
                                'class' => 'amodalinfoprofesional btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);


                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['informeprofesional/delete', 'id' => $model->id]), 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },

                ]
            
            ],*/
        ],
    ]); ?>
    
</div>
