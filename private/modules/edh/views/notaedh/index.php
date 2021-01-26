<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\NotaedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="notaedh-index">

    
    <p>
        <?= Html::button('< Volver', ['value' => Url::to(['viewlegajo', 'det' => $det]), 'title' => 'Notas de '.$materia,  'class' => 'btn btn-primary amodalplancursado']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if ($model->tiponota == 2){
                return ['class' => 'warning', 'id' => $model->id];
            }
            
        },
        'summary' => false,
        'striped' => false,
        'hover' => true,
        'columns' => [
            [
                'label' => 'Trimestre', 
                'group' => true,
                'value' => function($model){
                    return str_replace('Trimestral', 'Trimestre', $model->trimestre0->nombre);
                    
                }
            ],
            [
                'label' => 'Tipo de nota', 
                'value' => function($model){
                    return $model->tiponota0->nombre;
                }
            ],
            [
                'label' => 'Nota', 
                'value' => function($model){
                    return $model->nota;
                }
            ],
            
            
            
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to(['notaedh/update', 'id' => $model->id]),
                            'title' => 'Modificar seguimiento',
                                'class' => 'amodalplancursado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);


                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['notaedh/delete', 'id' => $model->id]), 
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
