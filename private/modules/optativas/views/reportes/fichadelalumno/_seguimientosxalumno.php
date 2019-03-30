<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\InasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="inasistencia-index">

    <?= 
    GridView::widget([
        'dataProvider' => $dataProviderSeguimientos,
        'summary' => false,
        'columns' => [
            [
                'label' => 'Fecha',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                },
            ],
            [
                'label' => 'Descripción',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    return $model->descripcion;
                },
            ],
            
        ],
            

        
    ]); ?>
</div>