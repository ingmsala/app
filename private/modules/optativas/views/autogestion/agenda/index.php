<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ComisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Optativas del Alumno';

?>
<div class="comision-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Año de Cursada',
                'attribute' => 'comision0.optativa0.aniolectivo0.nombre',
            ],
            [
                'label' => 'Espacio Optativo',
                'attribute' => 'comision0.optativa0.actividad0.nombre',
            ],
            [
                'label' => 'Comisión',
                'attribute' => 'comision0.nombre',
            ],

            [
                'label' => 'Estado',
                'attribute' => 'estadomatricula0.nombre',
                
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{fichadelalumno}',

                
                'buttons' => [
                    'fichadelalumno' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/autogestion/agenda/view&id='.$model->id);
                    },
                    /*'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/comision/update&id='.$model['id']);
                    },
                    
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