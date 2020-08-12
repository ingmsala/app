<?php

use app\modules\libroclase\models\Programa;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';

?>


<div class="actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model) {

            $programas = Programa::find()->where(['actividad' => $model->id])->count();
                    if($programas==0){
                        return ['class' => 'danger'];
                    }
        },
        'columns' => [
            

            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            
            
            [
                'label' => 'Plan',
                'attribute' => 'plan',
                'value' => 'plan0.nombre'
            ],
            [
                'label' => 'Propuesta Formativa',
                'attribute' => 'propuesta',
                'value' => 'propuesta0.nombre'
            ],

            [
                'label' => 'Programas vigentes',
                'value' => function($model){
                    $programas = Programa::find()->where(['actividad' => $model->id])->count();
                    if($programas>0){
                        return 'Sí';
                    }
                    return 'No';
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{viewdetcat} ',

                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',
                            '?r=libroclase/programa/index&id='.$model['id']);
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
