<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ComisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Espacios Optativos Cursados';

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
                'attribute' => 'comision0.espaciocurricular0.aniolectivo0.nombre',
            ],
            [
                'label' => 'Espacio Curricular',
                'attribute' => 'comision0.espaciocurricular0.actividad0.nombre',
            ],
            [
                'label' => 'Tipo de Espacio',
                'value' => function($model){
                    if($model->comision0->espaciocurricular0->tipoespacio == 1){
                        return 'Espacio Optativo';
                    }else{
                        return 'Proyecto Sociocomunitario';
                    }
                },
                'attribute' => '',
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
                            '?r=curriculares/autogestion/fichadelalumno&id='.$model->id);
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