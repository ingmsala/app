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




    <?= 

GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'toolbar'=>[
            '{toggleData}',
            ['content' => 
                Html::a('Historial', ['panelnovedadeshist'], ['class' => 'btn btn-default'])

            ],
            '{export}',

            
        ],

        //'filterModel' => $searchModel,
        'columns' => [
            
           [
                'format' => 'raw',
                'label' => '',
                'hiddenFromExport' => true,
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                    $itemsc = [];
                    
                    $formatter = \Yii::$app->formatter;
       
                    foreach($model->estadoxnovedads as $estadoxnovedad){
                        
                        $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                        
                    }
                    
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                                if($item[1]=='Activo')
                                    $boots='info';
                                elseif($item[1]=='En proceso')
                                    $boots='warning';
                                elseif($item[1]=='Rechazado')
                                    $boots='danger';
                                elseif($item[1]=='Presentó nota - Pendiente de revisión')
                                    $boots='warning';
                                else
                                    $boots='success';
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
                'visible' => ($tiponovedad==3 || $tiponovedad==5) ? false : true,
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
                        $aux = 0;
                        $c=0;
       
                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($estadoxnovedad->estadonovedad == 6)
                                $aux = 2.5;
                            else
                                $aux = $estadoxnovedad->estadonovedad;
                            if($c==0)
                                $max = $aux;
                            ($max>=$aux) ? $max=$max : $max=$aux;
                            $c=$c+1;
                        }
                        //return var_dump($model->estadoxnovedads);
                        if ($max ==  1)
                            return '<center><span style="color:orange;">Activo</span></center>';
                        elseif($max ==  2)          
                            return '<center><span style="color:green;">En proceso</span></center>';
                        elseif($max ==  3)          
                            return '<center><span style="color:green;">Finalizado</span></center>';
                        elseif($max ==  4)          
                            return '<center><span style="color:green;">Aprobado</span></center>';
                        elseif($max ==  5)          
                            return '<center><span style="color:red;">Rechazado</span></center>';
                        elseif($max ==  2.5)          
                            return '<center><span style="color:blue;">Presentó nota - Pendiente de revisión</span></center>';
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{savesec}',
                'hiddenFromExport' => true,
                'buttons' => [
                    'savesec' => function($url, $model, $key){
                        //return var_dump($model);
                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        //return Html::a('<span class="glyphicon glyphicon-ok"></span>',false,['class' => 'btn btn-success']);
                        //return var_dump(Yii::$app->request->get()['page']);
                        $itemsc = [];
                        $max=-1;
                        $c=0;
                        (isset(Yii::$app->request->get()['page'])) ? $page = Yii::$app->request->get()['page'] : $page = 1;

                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($estadoxnovedad->estadonovedad == 6)
                                $aux = 2.5;
                            else
                                $aux = $estadoxnovedad->estadonovedad;
                            if($c==0)
                                $max = $aux;
                            ($max>=$aux) ? $max=$max : $max=$aux;
                            $c=$c+1;
                        }
                        //return $max;
                        if ($max ==  1){
                            $lab0 = ["Recibir", "warning","Recibir la notificación y pasar la novedad a estado 'En Proceso'?",2];
                            $divbtn = Html::a($lab0[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab0[3].'&page='.$page, ['class' => 'btn btn-'.$lab0[1].' btn-sm',
                            'data' => [
                            'confirm' => $lab0[2],
                            'method' => 'post',
                             ]
                            
                            ]);
                        }
                        else
                            {
                                if($model->tiponovedad == 7){
                                    $lab = ["Rechazar", "danger", "Pasar la ausencia a trimestral a estado 'Rechazada' y guardarla en el historial?",5];
                                    $lab2 = ["Aprobar", "success", "Pasar la ausencia a trimestral a estado 'Aceptada' y guardarla en el historial?",4];
                                    $lab3 = ["Presentó nota", "info", "Pasar la ausencia a trimestral a estado 'Presentó Nota - Pendiente de revisión'?",6];
                                    $divbtn = '';
                                    if($max != 2.5){
                                        $divbtn .= Html::a($lab3[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab3[3].'&page='.$page, ['class' => 'btn btn-'.$lab3[1].' btn-sm',
                                            'data' => [
                                            'confirm' => $lab3[2],
                                            'method' => 'post',
                                             ]
                                        
                                        ]);
                                    }
                                        $divbtn .= Html::a($lab[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab[3].'&page='.$page, ['class' => 'btn btn-'.$lab[1].' btn-sm',
                                        'data' => [
                                        'confirm' => $lab[2],
                                        'method' => 'post',
                                         ]
                                    
                                    ]);
                                        $divbtn .='<br />'.Html::a($lab2[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab2[3].'&page='.$page, ['class' => 'btn btn-'.$lab2[1].' btn-sm',
                                        'data' => [
                                        'confirm' => $lab2[2],
                                        'method' => 'post',
                                         ]
                                    
                                    ]);
                                }

                                else{
                                    $lab = ["Finalizar", "success", "Pasar la novedad a estado 'Finalizada' y guardarla en el historial?",3];
                                    $divbtn = Html::a($lab[0], '?r=novedadesparte/nuevoestado&id='.$model['id'].'&estado='.$lab[3].'&page='.$page, ['class' => 'btn btn-'.$lab[1].' btn-sm',
                                        'data' => [
                                        'confirm' => $lab[2],
                                        'method' => 'post',
                                         ]
                                        
                                        ]);
                                }
                            }

                        return $divbtn;
                        
                        
                        

                    },
                    
                ]

            ],

            
        ],
        
]);




    
 ?>
</div>
