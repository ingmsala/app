<?php

use app\models\Departamento;
use app\modules\libroclase\models\desarrollo\Detalledesarrollo;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$desarrollox = $model;
if($desarrollox->estado==1)
    $tipolabel='info';
    else
    $tipolabel='success';
?>
<div class="horario-index">
    
    
    <?php
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode('Desarrollo de Programa '.$al->nombre.': '.$desarrollox->catedra0->division0->nombre.' - '.$programa->actividad0->nombre),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'toolbar'=>[
            ['content' => 
                '<div class="label label-'.$tipolabel.' label-large novisible">'.$desarrollox->estado0->nombre.'</div>'

            ],
            
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' =>'Unidad',
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                'value' => function($model){
                    if($model->detalleunidad0->nombre !=null)
                        return $model->detalleunidad0->unidad0->nombre.': '.$model->detalleunidad0->nombre;
                    else
                        return $model->detalleunidad0->unidad0->nombre;
                }
            ],

            [
                'label' =>'Tema',
                //'group' => true,
                'attribute' => 'tema',
                'value' => function($model){
                    return $model->descripcion;
                }
            ],

            
            [
                'label' => 'Dictado',
                'format' => 'raw',
                'width' => '20%',
                'value' => function($model)use($desarrollox){
                    $id = $model->id;
                    if($desarrollox->estado == 1)
                        $dis = false;
                    else
                        $dis = true;
                    
                    $detalledesarrollo = Detalledesarrollo::find()
                        ->where(['desarrollo' => $desarrollox->id])
                        ->andWhere(['temaunidad' => $id])
                        ->one();
                    if($detalledesarrollo == null){
                        $l1 = 'danger';
                        $l2 = 'default';
                        $l3 = 'default';
                    }else{

                        if($detalledesarrollo->estado==1){
                            $l1 = 'danger';
                            $l2 = 'default';
                            $l3 = 'default';
                        }elseif($detalledesarrollo->estado==3){
                            $l1 = 'default';
                            $l2 = 'primary';
                            $l3 = 'default';
                        }else{
                            $l1 = 'default';
                            $l2 = 'default';
                            $l3 = 'success';
                        }

                    }
                    return '<div class="btn-group" role="group" aria-label="...">'.
                    Html::button("No", 
                        [   
                            'class' => 'btn btn-'.$l1, 
                            'disabled'=> $dis,
                            'id' => 'nn'.$id.'nn',
                                'onclick' => '
                                    id = '.$id.';
                                    cl = "nn"+id+"nn";
                                    cl2 = "pp"+id+"pp";
                                    cl3 = "tt"+id+"tt";
                                    this.setAttribute("id", cl); 
                                    document.getElementById(cl).setAttribute("class", "btn btn-danger");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-default");

                                    $.ajax({
                                        url:"index.php?r=libroclase/desarrollo/detalledesarrollo/registrar",
                                        method:"post",
                                        data:{t: "'.$desarrollox->token.'", tema: '.$id.', estado: 1},
                                        success:function(data){
                                            //alert(data);
                                        },
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    });

                                '

                        ]).
                    Html::button("Parcial", 
                    [   
                        'class' => 'btn btn-'.$l2,
                        'disabled'=> $dis, 
                        'id' => 'pp'.$id.'pp',
                            'onclick' => '
                                id = '.$id.';
                                cl = "nn"+id+"nn";
                                cl2 = "pp"+id+"pp";
                                cl3 = "tt"+id+"tt";
                                this.setAttribute("id", cl2);                        
                                document.getElementById(cl).setAttribute("class", "btn btn-default");
                                document.getElementById(cl2).setAttribute("class", "btn btn-primary");
                                document.getElementById(cl3).setAttribute("class", "btn btn-default");
                                $.ajax({
                                    url:"index.php?r=libroclase/desarrollo/detalledesarrollo/registrar",
                                    method:"post",
                                    data:{t: "'.$desarrollox->token.'", tema: '.$id.', estado: 3},
                                    success:function(data){
                                        //alert(data);
                                    },
                                    error:function(jqXhr,asistio,error){
                                        //alert(error);
                                    }
                                });
                            '

                    ]).
                    Html::a("Sí",'#', 
                        [   
                            'class' => 'btn btn-'.$l3,
                            'disabled'=> $dis, 
                            'id' => 'tt'.$id.'tt',
                
                                'onclick' => '
                                    event.preventDefault();

                                    $.ajax({
                                        type     :"post",
                                        cache    : false,
                                        url      :"index.php?r=libroclase/desarrollo/detalledesarrollo/registrar",
                                        method:"post",
                                        data:{t: "'.$desarrollox->token.'", tema: '.$id.', estado: 2},
                                        error:function(jqXhr,asistio,error){
                                            //alert(error);
                                        }
                                    }).done(function (data) {
                                        
                                    
                                        //alert(data);
                                    });
                                    
                                    id = '.$id.';
                                    cl = "nn"+id+"nn";
                                    cl2 = "pp"+id+"pp";
                                    cl3 = "tt"+id+"tt";
                                    this.setAttribute("id", cl3);                              
                                    document.getElementById(cl).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl2).setAttribute("class", "btn btn-default");
                                    document.getElementById(cl3).setAttribute("class", "btn btn-success");
                                    
                                    
                                
                                '

                        ])
                .'</div><div class="clearfix"></div>';
                    
                    
                }
            ],
   
        ],
    ]); ?>
    <?php $form = ActiveForm::begin(); ?>
    <?php 
    
       echo ($model->estado==1) ? $form->field($model, 'motivo')->textarea(['rows' => 6]) : $form->field($model, 'motivo')->textarea(['rows' => 6, 'disabled' => 'disabled']); ?>

    <div class="form-group">
        <?php
        echo ($model->estado==1) ? Html::submitButton('Guardar y enviar', ['class' => 'btn btn-success']) : ''; ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
