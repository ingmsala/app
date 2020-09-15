<?php

use app\config\Globales;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\fonidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial de Fonid por Agente';

?>
<div class="fonid-index">

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' =>false,
        'toolbar'=>[
            ['content' => 
                ''

            ],
                        
        ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Apellido',
                'value' => function($modelok) {
                    if($modelok->docente0 != null){
                        return $modelok->docente0->apellido;
                    }else{
                        return $modelok->nodocente0->apellido;
                    }
                }
            ],
            [
                'label' => 'Nombre',
                'value' => function($modelok) {
                    if($modelok->docente0 != null){
                        return $modelok->docente0->nombre;
                    }else{
                        return $modelok->nodocente0->nombre;
                    }
                }
            ],
            
            [
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function($model){
                    if($model->estadofonid == 1)
                        return '<div class="label label-warning"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pendiente de envío</div>';
                    if($model->estadofonid == 2)
                        return '<div class="label label-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviada</div>';
                    if($model->estadofonid == 3)
                        return '<div class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptada</div>';
                    if($model->estadofonid == 4)
                        return '<div class="label label-danger"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Rechazada - Debe reenviar</div>';


                }
            ],
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            //'actividadnooficial',
            //'pasividad',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {borrar}',
                
                'buttons' => [
                    
                    'ver' => function($url, $model, $key){
                        if($model->estadofonid == 2 || $model->estadofonid == 3)
                            return Html::a(
                            '<span class="glyphicon glyphicon-print"></span>',
                            '?r=fonid/print&fn='.$model['id']);
                    },

                    /*'modificar' => function($url, $model, $key){
                        if($model->estadofonid == 1 || $model->estadofonid == 4)
                            return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=fonid/datospersonales');
                    },*/

                    'borrar' => function($url, $model, $key){
                        if(Yii::$app->user->identity->role == Globales::US_SUPER){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=fonid/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                        }
                        
                        
                    },
                ]

            ],
        ],
    ]); ?>
</div>
