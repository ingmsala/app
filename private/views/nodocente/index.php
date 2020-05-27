<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NodocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personal No docente';

?>
<div class="nodocente-index">

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'condensed' => true,
        //'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
            'after' => '<div class="container-fluid"><div class="row" style="text-align: center;">
                                    <div class="col-xs-3">
                                        <center>
                                            Planta <br />
                                            '.$planta.'
                                        </center>
                                        
                                    </div>
                                    <div class="col-xs-3">
                                        <center>
                                            Contratado <br />
                                            '.$contratados.'
                                        </center>
                                    </div>
                                    <div class="col-xs-3">
                                        <center>
                                            Total <br />
                                            '.($planta + $contratados).'
                                        </center>
                                    </div>
                                </div></div>',
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                Html::a('Agregar No docente', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'legajo',
            'documento',
            'apellido',
            'nombre',
            [
                'label' => "Condición",
                'attribute' => 'condicionnodocente0.nombre',
            ],
            'area',
            'categorianodoc',
            'mail',
                        
            

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{view} {viewdetcat} ',

                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=nodocente/view&id='.$model['id']);
                    },
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=nodocente/update&id='.$model['id']);
                    },
                    /*
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=catedra/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },*/
                ]

            ],
        ],
    ]); ?>
</div>