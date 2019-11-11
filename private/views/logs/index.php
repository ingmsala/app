<?php

use app\models\Catedra;
use app\models\Diasemana;
use app\models\Hora;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log de Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => "Reportes",
                'attribute' => '0',
                'value' => function($model){
                    return $model['0'];
                }
            ],
            [
                'label' => "",
                'attribute' => '1',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', $url = '?r=horario/'.Url::to($model['1']), ['option' => 'value']);
                }
            ],

            
            
            //'3.modelnew.catedra',
            

            
        ],
    ]); ?>
</div>
