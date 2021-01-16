<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\InformeprofesionalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="informeprofesional-index">

    <p style="margin-top:1em" class="pull-right">
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar informe', ['value' => Url::to('index.php?r=edh/informeprofesional/create&solicitud='.$solicitud), 'class' => 'btn btn-success amodalinfoprofesional']); ?>
    </p> 

    <div class="clearfix"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Área',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    return $model->areasolicitud0->nombre;
                }
            ],
            [
                'label' => 'Creado por',
                'value' => function($model){
                    return $model->agente0->apellido.', '.$model->agente0->nombre;
                }
            ],
            
            'descripcion:ntext',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
