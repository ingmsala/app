<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecasolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitud de beca';

?>
<div class="becasolicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->estudiante0->apellido.', '.$model->estudiante0->nombre;
                }
            ],
            [
                'label' => 'Solicitante',
                'value' => function($model){
                    return $model->solicitante0->apellido.', '.$model->solicitante0->nombre;
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return $model->estado0->nombre;
                }
            ],
            [
                'label' => 'Puntaje',
                'value' => function($model){
                    return '';
                }
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {imprimir} {rechazar} {aceptar}',
                
                'buttons' => [
                    
                    
                    'ver' => function($url, $model, $key){
                            return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',
                                    '?r=becas/default/finalizar&s='.$model->token);
                            
                            
                    },
                    'imprimir' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-print btn btn-default"></span>',
                            '?r=becas/default/print&s='.$model->token);
                    },
                    'rechazar' => function($url, $model, $key){
                            if($model->estado == 2)
                                 return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => Url::to('index.php?r=becas/default/rechazar&s='.$model->id), 'class' => 'btn btn-danger amodalrechazar']);
                        },
                    'aceptar' => function($url, $model, $key){
                            if($model->estado == 2)
                                return Html::a('<span class="glyphicon glyphicon-ok-circle btn btn-success"></span>', '?r=becas/default/aceptar', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>aceptar</b> la declaración jurada?',
                                'method' => 'post',
                                'params' => [
                                                's' => 3,
                                                'dj' => $model->id,
                                            ],
                                ]
                                ]);
                        
                        },

                    /*'borrar' => function($url, $model, $key){
                        if($model->estadodeclaracion == 1 || $model->estadodeclaracion == 4)
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=declaracionjurada/delete&id='.$model['dj'], 
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
