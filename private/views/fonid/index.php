<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeclaracionjuradaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FONID';
if($fonidfecha>0){
   $addnew =  Html::a('Nuevo FONID', ['create'], ['class' => 'btn btn-success', 'data' => [
    'confirm' => 'Ya tiene un FONID enviado con fecha de HOY, está seguro de querer crear uno nuevo?',
    'method' => 'post',
     ]]);
}else{
    $addnew =  Html::a('Nuevo FONID', ['create'], ['class' => 'btn btn-success']);
}
?>
<div class="fonid-index">

    <?php
        if(Yii::$app->params['devicedetect']['isMobile']){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
                
            $models = $dataProvider->getModels();
            
            foreach ($models as $modelok) {
                $i = 0;
                $fechaok = Yii::$app->formatter->asDate($modelok['fecha'], 'dd/MM/yyyy');
                echo '<div class="col-md-4">';
                echo DetailView::widget([
                    'model'=>$modelok,
                    'condensed'=>true,
                    'hover'=>true,
                    'mode'=>DetailView::MODE_VIEW,
                    'enableEditMode' => false,
                    'panel'=>[
                        'heading'=>$fechaok,
                        'headingOptions' => [
                            'template' => '',
                        ],
                        'type'=>DetailView::TYPE_DEFAULT,
                    ],
                    'attributes'=>[
                        
                        [
                            'label' => 'Apellido',
                            'value' => function() use($modelok) {
                                if($modelok->agente0 != null){
                                    return $modelok->agente0->apellido;
                                }
                            }
                        ],
                        [
                            'label' => 'Nombre',
                            'value' => function() use($modelok) {
                                if($modelok->agente0 != null){
                                    return $modelok->agente0->nombre;
                                }
                            }
                        ],
                        [
                            'label' => 'Estado',
                            'format' => 'raw',
                            'value' => function() use($modelok) {
                                if($modelok->estadofonid == 1)
                                    return '<div class="label label-warning"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pendiente de envío</div>';
                                if($modelok->estadofonid == 2)
                                    return '<div class="label label-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviada</div>';
                                if($modelok->estadofonid == 3)
                                    return '<div class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptada</div>';
                                
            
            
                            }
                            
                        ],
                        [
                            'label' => 'Acción',
                            'format' => 'raw',
                            'value' => function() use($modelok) {
                                if($modelok->estadofonid == 2 || $modelok->estadofonid == 3)
                                    return Html::a(
                                    '<span class="btn btn-primary">Imprimir</span>',
                                    '?r=fonid/print&fn='.$modelok->id);

                                if($modelok->estadofonid == 1 || $modelok->estadofonid == 4)
                                    return Html::a(
                                    '<span class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Continuar completando...</span>',
                                    '?r=fonid/update&id='.$modelok->id);
                            },
            
                            
                        ],
                        
                    ]
                ]);
                echo '</div>';
            }
            echo '<div class="clearfix"></div>'; 
            echo '<div class="btn-group-fab" role="group" aria-label="FAB Menu">';
            echo '<div>';
                
            

                
                echo Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-main btn-success']);
            

            echo '</div>';
            echo '</div>';
           } else{
            
       
       
            echo GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' =>false,
        'toolbar'=>[
            ['content' => $addnew
               

            ],
                        
        ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Apellido',
                'value' => function($modelok) {
                    if($modelok->agente0 != null){
                        return $modelok->agente0->apellido;
                    }
                }
            ],
            [
                'label' => 'Nombre',
                'value' => function($modelok) {
                    if($modelok->agente0 != null){
                        return $modelok->agente0->nombre;
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
                'template' => '{modificar} {imprimir}',
                
                'buttons' => [
                    
                    'ver' => function($url, $model, $key){
                        if($model->estadofonid == 2 || $model->estadofonid == 3)
                            return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=fonid/resumen&fn='.$model['id']);
                    },

                    'imprimir' => function($url, $model, $key){
                        try {
                            if($model->estadofonid == 2 || $model->estadofonid == 3)
                                return Html::a('<span class="glyphicon glyphicon-print"></span>', Url::to('index.php?r=fonid/print&fn='.$model['id']));
                            
                        } catch (\Throwable $th) {
                            return '';
                        }
                    },

                    'modificar' => function($url, $model, $key){
                        if($model->estadofonid == 1 || $model->estadofonid == 4)
                            return Html::a(
                            '<span class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Continuar completando...</span>',
                            '?r=fonid/update&id='.$model->id);
                    },

                    'borrar' => function($url, $model, $key){
                        if($model->estadofonid == 1 || $model->estadofonid == 4)
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=fonid/delete&id='.$model['id'], 
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
        }
    ?>
</div>


