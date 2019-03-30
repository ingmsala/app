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
        
        'dataProvider' => $dataProviderDetalleHoras,
        'summary' => false,
        'columns' => array_column($listClasescomision, 0),
    
    ]); ?>
</div>