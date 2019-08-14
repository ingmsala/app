<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NovedadesparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Novedades del parte';

?>
<div class="novedadesparte-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Nueva Novedad', ['value' => Url::to('index.php?r=novedadesparte/create&parte='.$model->id.'&preceptoria='.$model->preceptoria), 'class' => 'btn btn-success', 'id'=>'modalaNovedadesParte']) ?>
        
    </p>
    <div class="row">
        <div class="col-lg-6">
            <h3>Edilicias</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProvidernovedadesEdilicias,
                //'filterModel' => $searchModel,
                'columns' => [
                    
                      
                    [   
                        'label' => 'Fecha',
                        'attribute' => 'parte0.fecha',
                       
                        'value' => function($model){
                            //var_dump($model);
                            $formatter = \Yii::$app->formatter;
                            return $formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                            
                        }
                    ],
                    
                    [

                        'label' => 'Tipo de Novedad',
                        'attribute' => 'tiponovedad0.nombre',
                    ],
                    
                    
                   'descripcion:ntext',
                    [

                        'label' => 'Estado',
                        'format' => 'raw',
                        'value' => function($model){
                            $itemsc = [];
                            
                            $formatter = \Yii::$app->formatter;
                            
                            foreach($model->estadoxnovedads as $estadoxnovedad){
                                
                                $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                                
                            }
                            
                            return Html::ul($itemsc, ['item' => function($item) {
                                //var_dump($item);
                                    
                                        return 
                                                Html::tag('li', 
                                                $item[0].' - '.$item[1], ['class' => 'list-group-item list-group-item-success']);
                                }
                            , 'class' => "nav nav-pills nav-stacked"]);                  
                            //var_dump($itemsc);
                            //return implode(' // ', $itemsc);
                            //return $model->alumno0->dni;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',

                        'template' => '{update} {delete}',
                        
                        'buttons' => [
                            
                            'update' => function($url, $model, $key){

                                $itemsc = [];
                                $max=-1;
                                $c=0;
               
                                foreach($model->estadoxnovedads as $estadoxnovedad){
                                    if($c==0)
                                        $max = $estadoxnovedad->estadonovedad;
                                    ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                                    $c=$c+1;
                                }
                                if($max == 1 or in_array (Yii::$app->user->identity->role, [1]))
                                return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                    ['value' => Url::to('index.php?r=novedadesparte/update&id='.$model->id.'&parte=' .$model->parte),
                                        'class' => 'modala btn btn-link', 'id'=>'modalaModificarNovedad']);


                            },
                            'delete' => function($url, $model, $key){
                                $itemsc = [];
                                $max=-1;
                                $c=0;
               
                                foreach($model->estadoxnovedads as $estadoxnovedad){
                                    if($c==0)
                                        $max = $estadoxnovedad->estadonovedad;
                                    ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                                    $c=$c+1;
                                }
                                if($max == 1 or in_array (Yii::$app->user->identity->role, [1]))
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=novedadesparte/delete&id='.$model->id, 
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
        <div class="col-lg-6">
            <h3>Otras Novedades del Día</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    
                      
                    
                    
                    [

                        'label' => 'Tipo de Novedad',
                        'attribute' => 'tiponovedad0.nombre',
                    ],
                    
                     [
                        'label' => 'Docente',
                        'value' => function($model){
                            if($model->docente0 != null)
                                return $model->docente0['apellido'].', '.$model->docente0['nombre'];
                            else
                                return '';
                        }
                    ],
                                     
                    
                    'descripcion:ntext',
                    [

                        'label' => 'Estado',
                        'format' => 'raw',
                        'value' => function($model){
                            $itemsc = [];
                            
                            $formatter = \Yii::$app->formatter;
                            
                            foreach($model->estadoxnovedads as $estadoxnovedad){
                                
                                $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                                
                            }
                            
                            return Html::ul($itemsc, ['item' => function($item) {
                                //var_dump($item);
                                    
                                        return 
                                                Html::tag('li', 
                                                $item[0].' - '.$item[1], ['class' => 'list-group-item list-group-item-success']);
                                }
                            , 'class' => "nav nav-pills nav-stacked"]);                  
                            //var_dump($itemsc);
                            //return implode(' // ', $itemsc);
                            //return $model->alumno0->dni;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',

                        'template' => '{update} {delete}',
                        
                        'buttons' => [
                            
                            'update' => function($url, $model, $key){

                                $itemsc = [];
                                $max=-1;
                                $c=0;
               
                                foreach($model->estadoxnovedads as $estadoxnovedad){
                                    if($c==0)
                                        $max = $estadoxnovedad->estadonovedad;
                                    ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                                    $c=$c+1;
                                }
                                if($max == 1 or in_array (Yii::$app->user->identity->role, [1]))
                                return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                    ['value' => Url::to('index.php?r=novedadesparte/update&id='.$model->id.'&parte=' .$model->parte),
                                        'class' => 'modala btn btn-link', 'id'=>'modalaModificarNovedad']);


                            },
                            'delete' => function($url, $model, $key){
                                $itemsc = [];
                                $max=-1;
                                $c=0;
               
                                foreach($model->estadoxnovedads as $estadoxnovedad){
                                    if($c==0)
                                        $max = $estadoxnovedad->estadonovedad;
                                    ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                                    $c=$c+1;
                                }
                                if($max == 1 or in_array (Yii::$app->user->identity->role, [1]))
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=novedadesparte/delete&id='.$model->id, 
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
    </div>
    
    
</div>
