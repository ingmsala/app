<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'condensed' => true,
        'columns' => [
            
            [
                'label' => 'Ticket',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('#'.$model->id, Url::to(['view', 'id' => $model->id]));
                }
            ],
            /*'fecha',
            'hora',*/
            
            [
                'label' => 'Asunto',
                'attribute' => 'asunto',
                'width' => '50%',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->asunto, Url::to(['view', 'id' => $model->id]));
                }
            ],
            
            [
                'label' => 'Estado',
                'value' => function($model){
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
