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
        'dataProvider' => $dataProviderDetalleactividad,
        'summary' => false,
        'columns' => [
            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->actividad0->fecha, 'dd/MM/yyyy');
                }
            ],

            [
                'label' => 'Actividad',
                'value' => function($model){
                    return $model->actividad0->descripcion;
                }
                
            ],
            

            [
                'label' => 'Presentación',
                'value' => function($model){
                    try {
                        return $model->presentacion0->nombre;
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    
                }
                
            ],
            [
                'label' => 'Resultado',
                'value' => function($model){
                    try {
                        return $model->calificacion0->nombre;
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    
                }
                
            ],
            
        ],
            

        
    ]); ?>
</div>