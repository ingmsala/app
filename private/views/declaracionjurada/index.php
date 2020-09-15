<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeclaracionjuradaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Declaraciones Juradas';

?>
<div class="declaracionjurada-index">

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
                                if($modelok->docente0 != null){
                                    return $modelok->docente0->apellido;
                                }else{
                                    return $modelok->nodocente0->apellido;
                                }
                            }
                        ],
                        [
                            'label' => 'Nombre',
                            'value' => function() use($modelok) {
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
                            'value' => function() use($modelok) {
                                if($modelok->estadodeclaracion == 1)
                                    return '<div class="label label-warning"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pendiente de envío</div>';
                                if($modelok->estadodeclaracion == 2)
                                    return '<div class="label label-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviada</div>';
                                if($modelok->estadodeclaracion == 3)
                                    return '<div class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptada</div>';
                                if($modelok->estadodeclaracion == 4)
                                    return '<div class="label label-danger"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Rechazada - Debe reenviar</div>';
            
            
                            }
                            
                        ],
                        [
                            'label' => 'Acción',
                            'format' => 'raw',
                            'value' => function() use($modelok) {
                                if($modelok->estadodeclaracion == 2 || $modelok->estadodeclaracion == 3)
                                    return Html::a(
                                    '<span class="btn btn-primary">Ver</span>',
                                    '?r=declaracionjurada/resumen&dj='.$modelok->id);

                                if($modelok->estadodeclaracion == 1 || $modelok->estadodeclaracion == 4)
                                    return Html::a(
                                    '<span class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Continuar completando...</span>',
                                    '?r=declaracionjurada/datospersonales');
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
            ['content' => 
                Html::a('Nueva Declaración Jurada', ['create'], ['class' => 'btn btn-success'])

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
                    if($model->estadodeclaracion == 1)
                        return '<div class="label label-warning"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pendiente de envío</div>';
                    if($model->estadodeclaracion == 2)
                        return '<div class="label label-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviada</div>';
                    if($model->estadodeclaracion == 3)
                        return '<div class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptada</div>';
                    if($model->estadodeclaracion == 4)
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
                'template' => '{ver} {modificar} {imprimir}',
                
                'buttons' => [
                    
                    'ver' => function($url, $model, $key){
                        if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                            return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=declaracionjurada/resumen&dj='.$model['id']);
                    },

                    'imprimir' => function($url, $model, $key){
                        try {
                            if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                                return Html::a('<span class="glyphicon glyphicon-print"></span>', Url::to('index.php?r=declaracionjurada/print&dj='.$model['id']));;
                            
                        } catch (\Throwable $th) {
                            return '';
                        }
                    },

                    'modificar' => function($url, $model, $key){
                        if($model->estadodeclaracion == 1 || $model->estadodeclaracion == 4)
                            return Html::a(
                            '<span class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Continuar completando...</span>',
                            '?r=declaracionjurada/datospersonales');
                    },

                    'borrar' => function($url, $model, $key){
                        if($model->estadodeclaracion == 1 || $model->estadodeclaracion == 4)
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=declaracionjurada/delete&id='.$model['id'], 
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

