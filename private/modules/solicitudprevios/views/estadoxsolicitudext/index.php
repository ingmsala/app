<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="estadoxsolicitudext-index">

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');

                }
            ],
            'estado0.nombre',
            [
                'label' => 'Realizado por',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return $model->agente0->getNombreCompleto();

                }
            ],
            'motivo:ntext',

        ],
    ]); ?>
</div>
