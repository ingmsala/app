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
        'dataProvider' => $dataProviderInasistencias,
        'summary' => false,
        'columns' => array_column($listClasescomision, 0),
            /*[
                'label' => 'Fecha',
                'attribute' => 'clase0.fecha',
                'value' => function($model){
                     date_default_timezone_set('America/Argentina/Buenos_Aires');
                     return Yii::$app->formatter->asDate($model->clase0->fecha, 'dd/MM/yyyy');
                },
            ]*/
            
            

        
    ]); ?>
</div>