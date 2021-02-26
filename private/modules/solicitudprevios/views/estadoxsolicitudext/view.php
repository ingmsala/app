<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


\yii\web\YiiAsset::register($this);
?>
<div class="estadoxsolicitudext-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Fecha de rechazo',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');

                }
            ],
            [
                'label' => 'Rechazada por',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return $model->agente0->getNombreCompleto();

                }
            ],
            'motivo:ntext',
            
        ],
    ]) ?>

</div>
