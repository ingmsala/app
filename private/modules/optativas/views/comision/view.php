<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Comision */

$this->title = $model->espaciocurricular0->actividad0->nombre.' - Comisión: '.$model->nombre;

?>
<div class="comision-view">

    <h2><?= Html::encode($this->title) ?></h2>


    
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Agregar Docente', ['/optativas/docentexcomision/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

<h3>Profesores de la Comisión</h3>
<?= GridView::widget([
        'dataProvider' => $dataProviderdocentes,
        'summary' => '<br>',
        
        'columns' => [

            
            [   
                'label' => 'Legajo',
                'attribute' => 'docente0.legajo'
            ],      

            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],

            [   
                'label' => 'Rol',
                'attribute' => 'role0.nombre',
                'value' => function($model){
                    return $model->role0->nombre;
                }
            ],

            
            
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/docentexcomision/view&id='.$model->id);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/docentexcomision/update&id='.$model->id);


                    },
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=optativas/docentexcomision/delete&id='.$model->id, 
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


    <h3>Preceptores de la Comisión</h3>


<?= GridView::widget([
        'dataProvider' => $dataProviderpreceptores,
        'summary' => '<br>',
        
        'columns' => [

            
            [   
                'label' => 'Legajo',
                'attribute' => 'docente0.legajo'
            ],      

            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],

            [   
                'label' => 'Rol',
                'attribute' => 'role0.nombre',
                'value' => function($model){
                    return $model->role0->nombre;
                }
            ],

            
            
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/docentexcomision/view&id='.$model->id);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/docentexcomision/update&id='.$model->id);


                    },
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=optativas/docentexcomision/delete&id='.$model->id, 
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
