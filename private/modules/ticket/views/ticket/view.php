<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = 'Ticket #'.$model->id;

?>
<div class="ticket-view">

    <h2><?= Html::encode($this->title)?></h2>
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php

        echo '<div class="col-md-12">';
        //echo use 
        echo DetailView::widget([
            'model'=>$model,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel'=>[
                'heading'=>$model->asunto,
                'headingOptions' => [
                    'template' => '',
                ],
                'type'=>DetailView::TYPE_PRIMARY ,
                'footer' => $model->descripcion,
                'footerOptions' => ['style' => 'background-color:#fff']
            ],
            'attributes'=>[
                /*'fecha',
                'hora',
                'asunto',
                'descripcion:ntext',
                'estadoticket',
                'agente',
                'asignacionticket',
                'prioridadticket',*/
                [
                    'columns' => 
                        [
                            [
                                'label' => 'Abierto',
                                //'attribute'=>'fecha',
                                'value' => $model->fecha." - ".$model->hora 
                            ],
                            
                            [
                                'label' => 'Prioridad',
                                'format' => 'raw',
                                'value' => $model->prioridadticket0->nombre
                            ],

                            [
                                'label' => 'Estado',
                                'format' => 'raw',
                                'value' => ($model->estadoticket == 1) ? '<span class="label label-success">'.$model->estadoticket0->nombre.'</span>' : '<span class="label label-danger">'.$model->estadoticket0->nombre.'</span>'
                            ],
                        
                        ],
                ],

                [
                    'columns' => 
                        [
                            [
                                'label' => 'Creado por',
                                'value' => $model->agente0->apellido.", ".$model->agente0->apellido, 
                            ],
                            
                            [
                                'label' => 'Asignado a',
                                'value' => $model->asignacionticket0->agente ? $model->asignacionticket0->agente0->apellido.', '.$model->asignacionticket0->agente0->nombre : $model->asignacionticket0->areaticket0->nombre
                            ]
                        
                        ],
                ],

                [
                    'group'=>true,
                    'label'=>'Descripción',
                    'rowOptions'=>['class'=>'warning']
                ],

                
            
            ]
        ]);
        echo '</div>';
                
                $arr = ArrayHelper::map($adjuntos,'url', 'nombre');
                
                foreach ($arr as $key => $img) {
                    echo Html::a($img, 'assets/images/tickets/'.$key, ['target'=>'_blank']);
                }
        

    ?>

    

</div>
