<?php

use kartik\grid\GridView;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\ParticipantereunionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="participantereunion-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'condensed' => true,
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
            
                'template' => '{delete}'
            ],
        ],
    ]); ?>
</div>
