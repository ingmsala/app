<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\web\View;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

//$this->title = $model->id;
$this->title = $model->cantHoras;

?>
<div class="detalle-catedra-view">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){

                        if ($model['horas'] != $this->title){
                            return ['class' => 'danger'];
                        }
                        
        },
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode($model->nombre).' (Horas: '.$model->cantHoras.')',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
            ],
            

        ],

        'toolbar'=>[
            '{export}',
            
        ],
        'columns' => [
                      
            
            [
                'label' => 'Division',
                'attribute' => 'division'
            ],
            [
                'label' => 'Apellido',
                'attribute' => 'apellido'
            ],
            [
                'label' => 'Nombre',
                'attribute' => 'nombre',
                
            ],
            [
                'label' => 'Horas',
                'attribute' => 'horas',
                
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model['id'] != '' ? Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=catedra/view&id='.$model['id']) : '';


                    },
                    
                ]

            ],


                      

            
        ],
    ]); ?>

    

</div>