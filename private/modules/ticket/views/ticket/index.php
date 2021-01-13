<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;

?>
<div class="ticket-index">

    <p>
        <h3>Sistema de Tickets</h3>
    Para unificar los canales de comunicación, agilizar los procesos y brindar un mejor seguimiento y gestión de las solicitudes de las diferentes áreas, se implementa un sistema de tickets. 
    A cada solicitud se le asigna un número de ticket único que puede usar para rastrear el progreso y las respuestas en línea.
    Además, podrá consultar los ticket abiertos y cerrados a manera de historial de todas sus solicitudes, para poder consultar de referencia.
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'condensed' => true,
        'hover' => true,
        

        /*'rowOptions' => function($model){
            if ($model['estadoticket'] == 1){
                return ['class' => 'default'];
            }
            return ['class' => 'danger'];
        },*/
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'toolbar'=>[
            ['content' => 
                
                Html::tag('div', Html::a('<center>Mis tickets<br />Abiertos</center>', ['index', 'rpt' => 1], ['class' => $class1.' role="group"']).
                Html::a('<center>Mis tickets<br />Cerrados</center>', ['index', 'rpt' => 2], ['class' => $class2.' role="group"']).
                Html::a('<center>Mis tickets<br />Abiertos y cerrados</center>', ['index', 'rpt' => 3], ['class' => $class3.' role="group"']).
                Html::a('<center><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><br />Nuevo ticket</center>', ['create'], ['class' => 'btn btn-success'])),
                'options' => [ 'class' => 'btn-group btn-group-xs ' ]   
            ],
            
            
            
        ],

        'columns' => [
            
            [
                'label' => 'Ticket',
                'format' => 'raw',
                'width' => '1%',
                'value' => function($model){
                    return Html::a('#'.$model->id, Url::to(['view', 'id' => $model->id]));
                }
            ],
            /*'fecha',
            'hora',*/
            
            [
                'label' => 'Asunto',
                'attribute' => 'asunto',
                'width' => '40%',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->asunto, Url::to(['view', 'id' => $model->id]));
                }
            ],
            
            [
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function($model){
                    return ($model->estadoticket == 1) ? '<span class="label label-success">'.$model->estadoticket0->nombre.'</span>' : '<span class="label label-danger">'.$model->estadoticket0->nombre.'</span>';
                    return $model->estadoticket0->nombre;
                }
            ],
            [
                'label' => 'Creado por',
                'value' => function($model){
                    return $model->agente0->apellido.', '.$model->agente0->nombre;
                }
            ],
            [
                'label' => 'Asignado a',
                'value' => function($model){
                    if($model->asignacionticket0->agente==null){
                        return $model->asignacionticket0->areaticket0->nombre;
                    }
                    return $model->asignacionticket0->agente0->apellido.', '.$model->asignacionticket0->agente0->nombre;
                }
            ],
            //'asignacionticket',
            //'prioridadticket',
            //'clasificacionticket',

            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
