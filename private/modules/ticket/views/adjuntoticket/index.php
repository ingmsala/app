<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\AdjuntoticketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjuntotickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjuntoticket-index">

    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'summary' => false,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
        
                    'nombre',
        
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{delete}',
                        
                        'buttons' => [
                            'delete' => function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=ticket/adjuntoticket/delete&id='.$model->id, 
                                    ['data' => [
                                    'confirm' => 'Está seguro de querer eliminar este elemento?',
                                    'method' => 'post',
                                     ]
                                    ]);
                            },
                        ]
        
                    ],
                ],
            ]);
        ?>
</div>
