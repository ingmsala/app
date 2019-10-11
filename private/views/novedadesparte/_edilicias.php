<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\NovedadesparteSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Novedades del parte';
?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Nueva Novedad', ['value' => Url::to('index.php?r=novedadesparte/create&parte='.$model->id.'&preceptoria='.$model->preceptoria), 'class' => 'btn btn-success', 'id'=>'modalaNovedadesParte']) ?>
        
    </p>

<h3>Edilicias</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProvidernovedadesEdilicias,
                //'filterModel' => $searchModel,
                'columns' => [
                    
                      
                    [

                        'label' => '',
                        'attribute' => 'parte0.preceptoria0.nombre',
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

                        'template' => '{delete}',
                        
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