<?php

use app\modules\sociocomunitarios\models\Detalleactividadpsc;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Actividadpsc */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$this->title = $actividad->descripcion.' - '.Yii::$app->formatter->asDate($actividad->fecha, 'dd/MM/yyyy');;

\yii\web\YiiAsset::register($this);
?>
<div class="actividadpsc-view">

    <?= 

    GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        'floatHeader'=>true,
        
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'condensed' => true,

        'rowOptions' => function($model) use ($actividad){
            $detalleactividad = Detalleactividadpsc::find()
                        ->where(['actividad' => $actividad->id])
                        ->andWhere(['matricula' => $model->id])
                        ->one();
            try {
                if ($detalleactividad->presentacion == null || $detalleactividad->calificacion == null){
                    return ['class' => 'warning'];
                }
            } catch (\Throwable $th) {
                return ['class' => 'warning'];
            }
            
            
        },
        

        'toolbar'=>[
            
            '',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->alumno0->nombreCompleto;
                }
            ],
            
            
            [
                'label' => 'Presentación',
                'format' => 'raw',
                
                'value' => function($model)use($actividad){
                    $idmatricula = $model->id;
                    /*if($actividad->estado == 1)
                        $dis = false;
                    else*/
                        $dis = false;

                    
                    $detalleactividad = Detalleactividadpsc::find()
                        ->where(['actividad' => $actividad->id])
                        ->andWhere(['matricula' => $model->id])
                        ->one();
                    if($detalleactividad == null){
                        $l1 = 'default';
                        $l2 = 'default';
                        $l3 = 'default';
                    }else{

                        if($detalleactividad->presentacion==1){
                            $l1 = 'success';
                            $l2 = 'default';
                            $l3 = 'default';
                        }elseif($detalleactividad->presentacion==2){
                            $l1 = 'default';
                            $l2 = 'warning';
                            $l3 = 'default';
                        }elseif($detalleactividad->presentacion==3){
                            $l1 = 'default';
                            $l2 = 'default';
                            $l3 = 'danger';
                        }else{
                            $l1 = 'default';
                            $l2 = 'default';
                            $l3 = 'default';
                        }

                    }
                    return '<div class="btn-group" role="group" aria-label="...">'.
                    Html::button("Presentó", 
                        [   
                            'class' => 'btn btn-'.$l1, 
                            'disabled'=> $dis,
                            'id' => 'nn'.$idmatricula.'nn',
                                'onclick' => '
                                    idmat = '.$idmatricula.';
                                    cl = "nn"+idmat+"nn";
                                    cl2 = "pp"+idmat+"pp";
                                    cl3 = "tt"+idmat+"tt";
                                    this.setAttribute("id", cl);

                                    document.getElementById(cl).setAttribute("class", "btn btn-success");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-default");

                                    $.ajax({
                                        url:"index.php?r=sociocomunitarios/detalleactividadpsc/presentacion",
                                        method:"post",
                                        data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 1},
                                        success:function(data){
                                            //alert(data);
                                        },
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    });

                                    xcl = "apr"+idmat+"apr";
                                    xcl2 = "reac"+idmat+"reac";
                                    xcl3 = "desap"+idmat+"desap";
                                        
                                    document.getElementById(xcl).removeAttribute("disabled");
                                    document.getElementById(xcl2).removeAttribute("disabled");
                                    document.getElementById(xcl3).removeAttribute("disabled");

                                '

                        ]).
                    Html::button("Presentó fuera de término", 
                    [   
                        'class' => 'btn btn-'.$l2,
                        'disabled'=> $dis, 
                        'id' => 'pp'.$idmatricula.'pp',
                            'onclick' => '
                                idmat = '.$idmatricula.';
                                cl = "nn"+idmat+"nn";
                                cl2 = "pp"+idmat+"pp";
                                cl3 = "tt"+idmat+"tt";
                                this.setAttribute("id", cl2);                        
                                document.getElementById(cl).setAttribute("class", "btn btn-default");
                                document.getElementById(cl2).setAttribute("class", "btn btn-warning");
                                document.getElementById(cl3).setAttribute("class", "btn btn-default");
                                
                                $.ajax({
                                    url:"index.php?r=sociocomunitarios/detalleactividadpsc/presentacion",
                                    method:"post",
                                    data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 2},
                                    success:function(data){
                                        //alert(data);
                                    },
                                    error:function(jqXhr,asistio,error){
                                        //alert(error);
                                    }
                                });

                                xcl = "apr"+idmat+"apr";
                                xcl2 = "reac"+idmat+"reac";
                                xcl3 = "desap"+idmat+"desap";
                                    
                                document.getElementById(xcl).removeAttribute("disabled");
                                document.getElementById(xcl2).removeAttribute("disabled");
                                document.getElementById(xcl3).removeAttribute("disabled");
                            '

                    ]).
                    Html::a("No presentó",'#', 
                        [   
                            'class' => 'btn btn-'.$l3,
                            'disabled'=> $dis, 
                            'id' => 'tt'.$idmatricula.'tt',
                
                                'onclick' => '
                                    event.preventDefault();

                                    $.ajax({
                                        type     :"post",
                                        cache    : false,
                                        url      :"index.php?r=sociocomunitarios/detalleactividadpsc/presentacion",
                                        method:"post",
                                        data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 3},
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    }).done(function (data) {
                                        
                                    
                                        //alert(data);
                                    });
                                    
                                    idmat = '.$idmatricula.';
                                    cl = "nn"+idmat+"nn";
                                    cl2 = "pp"+idmat+"pp";
                                    cl3 = "tt"+idmat+"tt";
                                    this.setAttribute("idmat", cl3);                              
                                    document.getElementById(cl).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-danger");

                                    xcl = "apr"+idmat+"apr";
                                    xcl2 = "reac"+idmat+"reac";
                                    xcl3 = "desap"+idmat+"desap";
                                    
                                    document.getElementById(xcl).setAttribute("class", "btn btn-default");
                                    document.getElementById(xcl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(xcl3).setAttribute("class", "btn btn-danger");

                                    document.getElementById(xcl).setAttribute("disabled", "disabled");
                                    document.getElementById(xcl2).setAttribute("disabled", "disabled");
                                    document.getElementById(xcl3).setAttribute("disabled", "disabled");
                                    
                                    
                                
                                '

                        ])
                .'</div>'.Html::a('×', ['/sociocomunitarios/detalleactividadpsc/nullpresentacion', 'id' => $model->id], [
                    'class' => 'close',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'act' => $actividad->id,
                            'm' => $model->id,
                            'estado' => null,
                        ]
                    ],
                ])
                .'<div class="clearfix"></div>';
                    
                    
                }
            ],

            [
                'label' => 'Resultado',
                'format' => 'raw',
                
                'value' => function($model)use($actividad){
                    $idmatricula = $model->id;
                    /*if($actividad->estado == 1)
                        $dis = false;
                    else*/
                        

                    
                    $detalleactividad = Detalleactividadpsc::find()
                        ->where(['actividad' => $actividad->id])
                        ->andWhere(['matricula' => $model->id])
                        ->one();
                    
                    if($detalleactividad == null){
                        $l1 = 'default';
                        $l2 = 'default';
                        $l3 = 'default';
                        $dis = true;
                    }else{

                        if($detalleactividad->calificacion==1){
                            $l1 = 'success';
                            $l2 = 'default';
                            $l3 = 'default';
                            
                        }elseif($detalleactividad->calificacion==2){
                            $l1 = 'default';
                            $l2 = 'warning';
                            $l3 = 'default';
                            
                        }elseif($detalleactividad->calificacion==3){
                            $l1 = 'default';
                            $l2 = 'default';
                            $l3 = 'danger';
                            
                        }else{
                            $l1 = 'default';
                            $l2 = 'default';
                            $l3 = 'default';
                            
                        }

                        if($detalleactividad->presentacion==3){
                            $dis = true;
                        }else{
                            $dis = false;
                        }


                    }
                    return '<div class="btn-group" role="group" aria-label="...">'.
                    Html::button("Aprobado", 
                        [   
                            'class' => 'btn btn-'.$l1, 
                            'disabled'=> $dis,
                            'id' => 'apr'.$idmatricula.'apr',
                                'onclick' => '
                                    id = '.$idmatricula.';
                                    cl = "apr"+id+"apr";
                                    cl2 = "reac"+id+"reac";
                                    cl3 = "desap"+id+"desap";
                                    this.setAttribute("id", cl);
                                     
                                    document.getElementById(cl).setAttribute("class", "btn btn-success");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-default");

                                    $.ajax({
                                        url:"index.php?r=sociocomunitarios/detalleactividadpsc/calificacion",
                                        method:"post",
                                        data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 1},
                                        success:function(data){
                                            //alert(data);
                                        },
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    });

                                '

                        ]).
                    Html::button("Rehacer o completar", 
                    [   
                        'class' => 'btn btn-'.$l2,
                        'disabled'=> $dis, 
                        'id' => 'reac'.$idmatricula.'reac',
                            'onclick' => '
                                id = '.$idmatricula.';
                                cl = "apr"+id+"apr";
                                cl2 = "reac"+id+"reac";
                                cl3 = "desap"+id+"desap";
                                this.setAttribute("id", cl2);                        
                                document.getElementById(cl).setAttribute("class", "btn btn-default");
                                document.getElementById(cl2).setAttribute("class", "btn btn-warning");
                                document.getElementById(cl3).setAttribute("class", "btn btn-default");
                                $.ajax({
                                    url:"index.php?r=sociocomunitarios/detalleactividadpsc/calificacion",
                                    method:"post",
                                    data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 2},
                                    success:function(data){
                                        //alert(data);
                                    },
                                    error:function(jqXhr,asistio,error){
                                        //alert(error);
                                    }
                                });
                            '

                    ]).
                    Html::a("Desaprobado",'#', 
                        [   
                            'class' => 'btn btn-'.$l3,
                            'disabled'=> $dis, 
                            'id' => 'desap'.$idmatricula.'desap',
                
                                'onclick' => '
                                    event.preventDefault();

                                    $.ajax({
                                        type     :"post",
                                        cache    : false,
                                        url      :"index.php?r=sociocomunitarios/detalleactividadpsc/calificacion",
                                        method:"post",
                                        data:{act: "'.$actividad->id.'", m: '.$idmatricula.', estado: 3},
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    }).done(function (data) {
                                        
                                    
                                        //alert(data);
                                    });
                                    
                                    id = '.$idmatricula.';
                                    cl = "apr"+id+"apr";
                                    cl2 = "reac"+id+"reac";
                                    cl3 = "desap"+id+"desap";
                                    this.setAttribute("id", cl3);                              
                                    document.getElementById(cl).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-danger");
                                    
                                    
                                
                                '

                        ])
                .'</div>'.Html::a('×', ['/sociocomunitarios/detalleactividadpsc/nullcalificacion', 'id' => $model->id], [
                    'class' => 'close',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'act' => $actividad->id,
                            'm' => $model->id,
                            'estado' => null,
                        ]
                    ],
                ])
                .'<div class="clearfix"></div>';
                    
                    
                }
            ],
            

             
            
                        
           
        ],
        //'pjax' => true,
    ]);
    ?>

</div>
