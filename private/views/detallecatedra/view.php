<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = $model->id;

?>
<div class="detalle-catedra-view">

    <h1><?= 'Catedra Id: '.Html::encode($this->title) ?></h1>

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',

            [   
                'label'=>"Condición",
                'attribute' => 'condicion0.nombre'
            ],

            [
                'label'=>"Apellido",
                'attribute' => 'agente0.apellido'
            ],
            [
                'label'=>"Nombre",
                'attribute' => 'agente0.nombre'
            ],
            [   
                'label'=>"Actividad",
                'attribute' => 'catedra0.actividad0.nombre'
            ],
            [   
                'label'=>"División",
                'attribute' => 'catedra0.division0.nombre'
            ],
            
            [   
                'label'=>"Revista",
                'attribute' => 'revista0.nombre'
            ],
            [   
                'label'=>"Horas",
                'attribute' => 'hora'
            ],
            [   
                'label'=>"Resolución",
                'attribute' => 'resolucion'
            ],
            [
                'label' => 'Fecha Inicio',
                'attribute' => 'fechaInicio',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fechaInicio, 'dd-MM-yyyy');
                }
            ],
            [
                'label' => 'Fecha Fin',
                'attribute' => 'fechaFin',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fechaFin, 'dd-MM-yyyy');
                }
            ],
        ],
    ]) ?>

</div>
