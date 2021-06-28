<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\AuthpagoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Órdenes de Pago';

?>
<div class="authpago-index">

    


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                ''

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => 'Fecha',
                
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                   return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            'ordenpago',
            [
                'label' => 'CUIT',
                'value' => function($model){
                    return $model->proveedor0->cuit;
                }
            ],
            [
                'label' => 'Proveedor',
                'value' => function($model){
                    return $model->proveedor0->nombre;
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return $model->estado0->nombre;
                }
            ],
            [
                'label' => 'Monto',
                'hAlign' => 'right',
                'value' => function($model){
                    $mod = str_replace('.',',', $model->monto);
                    if($model->monto == null)
                        return '$ -';
                    return '$ '.$mod;
                }
            ],
            
            

        ],
    ]); ?>
</div>
