<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AvisoinasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aviso de Inasistencias';
$this->params['breadcrumbs'][] = $this->title;

if(in_array (Yii::$app->user->identity->role, [1,4,26]))
        $template =  "{edit} {delete}";
    else
        $template =  "";
?>
<div class="avisoinasistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            if(in_array (Yii::$app->user->identity->role, [1,4,26]))
                echo Html::a('Nuevo aviso', ['create'], ['class' => 'btn btn-success']); 
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Área',
                'format' => 'raw',
                'value' => function($model){
                    if($model->tipoavisoparte == 2)
                        return '<span class="label label-danger">'.$model->tipoavisoparte0->nombre.'</span>';
                    else    
                        return $model->tipoavisoparte0->nombre;
                }
            ],
                        
            [
                'label' => 'Agente',
                'value' => function ($model){
                    if($model->agente0['apellido'] != null)
                        return $model->agente0['apellido'].', '.$model->agente0['nombre'];
                    return '-';
                }
            ],
            'descripcion:ntext',
            [
                'label' => 'Desde',
                'attribute' => 'desde',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $hoy = date("Y-m-d");
                    $tomorrow = strtotime ( '+1 day' , strtotime ( $hoy ) ) ;
                    $fourdays = strtotime ( '+4 day' , strtotime ( $hoy ) ) ;
                    $tomorrow = date ( 'Y-m-d' , $tomorrow );
                    $fourdays = date ( 'Y-m-d' , $fourdays );
                    if ($model['desde'] == $hoy){
                        return '<span class="label label-primary">HOY</span>';
                    }elseif($model['desde'] == $tomorrow ){
                        
                         return '<span class="label label-info">MAÑANA</span>';
                    }elseif($model['desde'] <= $fourdays &&  $model['desde'] > $hoy){
                            return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy').'<br /><span class="label label-warning">PRÓXIMAMENTE</span>';
                    }elseif($model['desde'] <= $fourdays && $model['hasta'] >= $hoy){
                            return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy').'<br /><span class="label label-danger">En curso</span>';
                        }   
                    return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy');
                } 
            ],
            [
                'label' => 'Hasta',
                'attribute' => 'hasta',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $hoy = date("Y-m-d");
                    $tomorrow = strtotime ( '+1 day' , strtotime ( $hoy ) ) ;
                    $tomorrow = date ( 'Y-m-d' , $tomorrow );
                    
                    if ($model['hasta'] == $hoy){
                        return '<span class="label label-primary">HOY</span>';
                    }elseif($model['hasta'] == $tomorrow ){
                        
                         return '<span class="label label-info">MAÑANA</span>';
                    }
                    return Yii::$app->formatter->asDate($model['hasta'], 'dd/MM/yyyy');
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'edit' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=avisoinasistencia/update&id='.$model['id']);
                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=avisoinasistencia/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },
                ]

            ],
        ],
    ]); ?>
</div>
