<?php

use yii\helpers\Html;
use kartik\grid\GridView;;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurnoexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turnos de examen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnoexamen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Turnoexamen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            [
                'label' => 'Desde',
                'attribute' => 'desde',
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Hasta',
                'attribute' => 'hasta',
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model['hasta'], 'dd/MM/yyyy');
                }
            ],
                        
            [
                'label' => 'Activo',
                'value' => function($model){
                    if($model->activo == 0)
                        return 'Inactivo';
                    elseif($model->activo == 1)
                        return 'Publicado';
                    else
                        return 'En carga';
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{view} {update} {delete}',

                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=mesaexamen/index&turno='.$model['id'].'&all=1');
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=turnoexamen/update&id='.$model['id']);
                    },
                    
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=turnoexamen/delete&id='.$model['id'], 
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
