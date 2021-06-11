<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\sociocomunitarios\models\ActividadpscSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';

?>
<div class="actividadpsc-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'floatHeader'=>true,
        
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'condensed' => true,
        

        'toolbar'=>[
            
            Html::a('Nueva Actividad', ['create'], ['class' => 'btn btn-success']),
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            'descripcion',
            

            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
