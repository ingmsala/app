<?php

use app\config\Globales;
use app\models\Actividadxmesa;
use app\models\Tribunal;
use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MesaexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $turnoex->nombre;

?>
<div class="mesaexamen-index">

    <?php
        if($all == 1){
            $a = Html::a('Filtrar mis mesas', Url::to('index.php?r=mesaexamen&turno=1&all=0'), ['class' => 'btn btn-success']);
        }else{
            $a = Html::a('Ver todo el turno', Url::to('index.php?r=mesaexamen&turno=1&all=1'), ['class' => 'btn btn-success']);
        }
    ?>


    <?php
        if(Yii::$app->params['devicedetect']['isMobile']){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
                
            $models = $dataProvider->getModels();
            
            foreach ($models as $model) {
                $i = 0;
                $fechaok = Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                echo '<div class="col-md-4">';
                echo DetailView::widget([
                    'model'=>$model,
                    'condensed'=>true,
                    'options' => ['style' => 'font-size:10px;'],
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
                            'label' => 'Hora',
                            'value' => function() use ($model){
                                $hora = explode(':', $model->hora);
                                return $hora[0].':'.$hora[1].' hs.';
                            }
                        ],
            
                        [
                            'label' => 'Asignaturas',
                            'format' => 'raw',
                            'value' => function() use ($model){
                                $salida = '<ul>';
                                $activxmesa = Actividadxmesa::find()->where(['mesaexamen' => $model->id])->all();
            
                                foreach ($activxmesa as $actividadxmesa) {
                                    $salida .= '<li>'.$actividadxmesa->actividad0->nombre.'</li>';
                                }
            
                                $salida .= '</ul>';
                                return $salida;
                            }
                        ],
                        [
                            'label' => 'Tribunal',
                            'format' => 'raw',
                            'value' => function() use ($model, $doc) {
                                $salida = '<ul>';
                                $trib = Tribunal::find()->where(['mesaexamen' => $model->id])->all();
            
                                foreach ($trib as $tribunal) {
                                    try {
                                        if($doc->documento == $tribunal->docente0->documento){
                                            $salida .= '<li><span style="background-color: #FFaaFF;">'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</span></li>';
                                        }else{
                                            $salida .= '<li>'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</li>';
                                        }
                                    } catch (\Throwable $th) {
                                        $salida .= '<li>'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</li>';
                                    }
                                    
            
                                    
                                }
            
                                $salida .= '</ul>';
                                return $salida;
                            }
                        ],

                        /*[
                            'label' => 'Acción',
                            'format' => 'raw',
                            'value' => function() use($model) {
                                if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                                    return Html::a(
                                    '<span class="btn btn-primary">Ver</span>',
                                    '?r=declaracionjurada/resumen&dj='.$model->id);

                                if($model->estadodeclaracion == 1 || $model->estadodeclaracion == 4)
                                    return Html::a(
                                    '<span class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Continuar completando...</span>',
                                    '?r=declaracionjurada/datospersonales');
                            },
            
                            
                        ],*/
                        
                    ]
                ]);
                echo '</div>';
            }
            echo '<div class="clearfix"></div>'; 
            echo '<div class="btn-group-fab" role="group" aria-label="FAB Menu">';
            echo '<div>';
                
            

                
                echo $a;
            

            echo '</div>';
            echo '</div>';
           } else{
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::PDF => [
                'label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'config' => [
                    'methods' => [
                        'SetHeader' => [
                            ['odd' => '']
                        ],
                        'SetFooter' => [
                            ['odd' => '']
                        ],
                    ],
                ]
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                (in_array (Yii::$app->user->identity->role, [Globales::US_SUPER])) ? Html::a('Nueva Mesa de examen', ['create'], ['class' => 'btn btn-success']) : $a 

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'nombre',
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            
            [
                'label' => 'Hora',
                'value' => function($model){
                    $hora = explode(':', $model->hora);
                    return $hora[0].':'.$hora[1].' hs.';
                }
            ],

            [
                'label' => 'Asignaturas',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    $activxmesa = Actividadxmesa::find()->where(['mesaexamen' => $model->id])->all();

                    foreach ($activxmesa as $actividadxmesa) {
                        $salida .= '<li>'.$actividadxmesa->actividad0->nombre.'</li>';
                    }

                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            [
                'label' => 'Tribunal',
                'format' => 'raw',
                'value' => function($model) use ($doc) {
                    $salida = '<ul>';
                    $trib = Tribunal::find()->where(['mesaexamen' => $model->id])->all();

                    foreach ($trib as $tribunal) {
                        try {
                            if($doc->documento == $tribunal->docente0->documento){
                                $salida .= '<li><span style="background-color: #FFaaFF;">'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</span></li>';
                            }else{
                                $salida .= '<li>'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</li>';
                            }
                        } catch (\Throwable $th) {
                            $salida .= '<li>'.$tribunal->docente0->apellido.', '.substr(ltrim($tribunal->docente0->nombre),0,1).'</li>';
                        }
                        

                        
                    }

                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            //'espacio',

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{view} {update} {delete}',

                'visible' => in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]),
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=mesaexamen/view&id='.$model['id']);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=mesaexamen/update&id='.$model['id']);
                    },
                    
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=mesaexamen/delete&id='.$model['id'], 
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
    } ?>
</div>
