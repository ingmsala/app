<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */


?>
<div class="turnoexamen-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'label' => 'Desde',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model->desde, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Hasta',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model->hasta, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Tipo de turno',
                'value' => function($model){
                    return $model->tipoturno0->nombre;
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return $model->estado0->nombre;
                }
            ],
        ],
    ]) ?>

</div>
