<?php

use kartik\grid\GridView;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\ParticipantereunionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$js = <<< JS
    function sendRequest(asistio, id){
        $.ajax({
            url:'index.php?r=edh/participantereunion/asistioupdate',
            method:'post',
            data:{asistio:asistio,id:id},
            success:function(data){
                //alert(data);
            },
            error:function(jqXhr,asistio,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);

$js2 = <<< JS
    function sendRequest2(comunico, id){
        $.ajax({
            url:'index.php?r=edh/participantereunion/comunicoupdate',
            method:'post',
            data:{comunico:comunico,id:id},
            success:function(data){
                //alert(data);
            },
            error:function(jqXhr,comunico,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js2, \yii\web\View::POS_READY);



?>
<div class="participantereunion-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'condensed' => true,
        'hover' => true,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Participante',
                
                'value' => function($model){
                    return $model->participante0->apellido.', '.$model->participante0->nombre;
                }
            ],
            [
                'label' => 'Tipo',
                'hAlign' => 'center',

                /*'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class*/
                
                'value' => function($model){
                    return $model->tipoparticipante0->nombre;
                }
            ],

            [
                'label' => 'Materia',
                'hAlign' => 'center',

                /*'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class*/
                
                'value' => function($model){
                    if($model->actividad != null)
                        return $model->actividad0->nombre;
                    return '';
                }
            ],

            [
                'label' => 'Mail',
                'hAlign' => 'center',

                'value' => function($model){
                    return $model->participante0->mail;
                }
            ],
            
            
            [
                'label' => 'Comunicó?',
                'format' => 'raw',
                'hAlign' => 'center',
                
                'value' => function($model){
                    if ($model->comunico == 0)
                        $val = false;
                    else
                        $val = true;
                        
                    return SwitchInput::widget([
                        'name' => 'statuscom_'.$model->id,
                        'value'=> $val,
                        'disabled' => $val,

                        'pluginEvents' => [
                            'switchChange.bootstrapSwitch' => "function(e){sendRequest2(e.currentTarget.checked, $model->id);}"
                        ],

                        'pluginOptions' => [
                            'size' => 'mini',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                        ]
                    ]);
                      
                }
            ],

            [
                'label' => 'Asistió?',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function($model){
                    if ($model->asistio == 0)
                        $val = false;
                    else
                        $val = true;
                        
                    return SwitchInput::widget([
                        'name' => 'statusasis_'.$model->id,
                        'value'=> $val,

                        'pluginEvents' => [
                            'switchChange.bootstrapSwitch' => "function(e){sendRequest(e.currentTarget.checked, $model->id);}"
                        ],

                        'pluginOptions' => [
                            'size' => 'mini',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                        ]
                    ]);
                      
                }
            ],
            

            ['class' => 'kartik\grid\ActionColumn',
            
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=edh/participantereunion/delete&id='.$model['id'], 
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
