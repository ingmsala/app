<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ComisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comisiones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comision-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Espacio',
                'value' => function($model){
                    return $model->espaciocurricular0->actividad0->nombre;
                }
            ],
            [
                'label' => 'Comisión',
                'attribute' => 'nombre',
            ],

            'cupo',

            [
                'label' => 'Docentes',
                'format' => 'raw',
                'value' => function($model){
                    try {
                        $salida = '<ul>';
                        foreach ($model->docentexcomisions as $dxc) {
                            $salida .= '<li>'.$dxc->agente0->apellido.', '.$dxc->agente0->nombre.'</li>';
                        }
                        $salida .= '</ul>';
                        return $salida;
                    } catch (\Throwable $th) {
                        return 'Sin docente asignado';
                    }
                    

                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{view} {update}',

                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/comision/view&id='.$model['id']);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/comision/update&id='.$model['id']);
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
