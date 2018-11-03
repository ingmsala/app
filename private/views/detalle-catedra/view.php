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
                'attribute' => 'docente0.apellido'
            ],
            [
                'label'=>"Nombre",
                'attribute' => 'docente0.nombre'
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
            'resolucion',
            'fechaInicio',
            'fechaFin',
        ],
    ]) ?>

</div>
