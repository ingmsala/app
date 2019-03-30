<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */

$this->title = $matr->alumno0->apellido.', '.$matr->alumno0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Seguimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguimiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nuevo Seguimiento', ['create', 'id' => $matricula], ['class' => 'btn btn-success']) ?>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            
            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            'descripcion',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                
                'buttons' => [
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/seguimiento/update&id='.$model->id);
                    },
                    'delete' => function($url, $model, $key){
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=optativas/seguimiento/delete&id='.$model->id, 
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
