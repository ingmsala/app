<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\DetalleescalanotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleescalanota-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Nota', ['detalleescalanota/create', 'en' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nota',
            [
                'label' => 'Escala de Notas',
                'attribute' => 'escalanota0.nombre', 
            ],
           
            [
                'label' => 'Condición',
                'attribute' => 'condicionnota0.nombre', 
            ],
            

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{modificar} ',

                
                'buttons' => [
                    'modificar' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/detalleescalanota/update&id='.$model['id']);
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
