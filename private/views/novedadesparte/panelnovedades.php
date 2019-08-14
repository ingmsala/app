<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Panel de Novedades';

?>


<div class="detalleparte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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


<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>

    <?= 

GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,

        //'filterModel' => $searchModel,
        'columns' => [
            
           [
                'format' => 'raw',
                'label' => '',
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                    $itemsc = [];
                    
                    $formatter = \Yii::$app->formatter;
       
                    foreach($model->estadoxnovedads as $estadoxnovedad){
                        
                        $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                        
                    }
                    
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                                ($item[1]=='Activo') ? $boots='warning' : $boots='success';
                                return 
                                        Html::tag('li', 
                                        $item[0].' - '.$item[1], ['class' => 'list-group-item list-group-item-'.$boots]);
                        }
                    , 'class' => "nav nav-pills nav-stacked"]);                  
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    //return $model->alumno0->dni;
                }
            ],
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

                'label' => 'Preceptoria',
                'attribute' => 'parte0.preceptoria0.nombre',

            ],

            [

                'label' => 'Tipo de Novedad',
                'attribute' => 'tiponovedad0.nombre',
            ],

            [
                'label' => 'Docente',
                'visible' => ($tiponovedad<>3) ? true : false,
                'value' => function($model){
                    if($model->docente0 != null)
                        return $model->docente0['apellido'].', '.$model->docente0['nombre'];
                    else
                        return '';
                }
            ],
            
            'descripcion:ntext',
            
            [
                'format' => 'raw',
                'label' => 'Estado',
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                        $itemsc = [];
                        $max=-1;
                        $c=0;
       
                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($c==0)
                                $max = $estadoxnovedad->estadonovedad;
                            ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                            $c=$c+1;
                        }
                        //return $max;
                        if ($max ==  1)
                            return '<center><span style="color:orange;">Activo</span></center>';
                                    
                            return '<center><span style="color:green;">En proceso</span></center>';
                },
            ],

            [
                'format' => 'raw',
                'label' => 'Tiempo respuesta',
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                        $itemsc = [];
                        $max=-1;
                        $c=0;
       
                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($c==0){
                                $max = $estadoxnovedad->estadonovedad;
                                $date1 = new DateTime($estadoxnovedad->fecha);
                            }
                            if ($max>=$estadoxnovedad->estadonovedad){
                                $max=$max;
                                $date2 = new DateTime(date("Y-m-d"));
                            }else{
                                $max=$estadoxnovedad->estadonovedad;
                                $date2 = new DateTime($estadoxnovedad->fecha);
                            }
                            $c=$c+1;
                        }
                        //return $max;
                        
                        $diff = $date1->diff($date2);
                        $dias = 'días';
                        if($diff->days>15)
                            $color='red';
                        elseif($diff->days>5)
                            $color='orange';
                        elseif($diff->days==1){
                            $color='green';
                             $dias = 'día';
                        }
                        else
                            $color='green';
                        // will output 2 days
                        //return $diff->days . ' días';
                        //if ($max ==  1)
                        return '<center><span style="color:'.$color.';">'.$diff->days.' '.$dias.'</span></center>';
                  
                },
            ],
            

            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savesec}',
                                
                'buttons' => [
                    'savesec' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        //return Html::a('<span class="glyphicon glyphicon-ok"></span>',false,['class' => 'btn btn-success']);
                        //return var_dump(Yii::$app->request->get()['page']);
                        $itemsc = [];
                        $max=-1;
                        $c=0;
                        (isset(Yii::$app->request->get()['page'])) ? $page = Yii::$app->request->get()['page'] : $page = 1;
                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($c==0)
                                $max = $estadoxnovedad->estadonovedad;
                            ($max>=$estadoxnovedad->estadonovedad) ? $max=$max : $max=$estadoxnovedad->estadonovedad;
                            $c=$c+1;
                        }
                        //return $max;
                        if ($max ==  1)
                            $lab = ["Recibir", "warning","Recibir la notificación y pasar la novedad a estado 'En Proceso'?",2];
                        else
                            $lab = ["Finalizar", "success", "Pasar la novedad a estado 'Finalizada' y guardarla en el historial?",3];

                        return Html::a($lab[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab[3].'&page='.$page, ['class' => 'btn btn-'.$lab[1].' btn-sm',
                            'data' => [
                            'confirm' => $lab[2],
                            'method' => 'post',
                             ]
                            
                            ]);
                        
                        
                        

                    },
                    
                ]

            ],

            
        ],
        'pjax' => true,
]);



Pjax::end();
    
 ?>
</div>
