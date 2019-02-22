<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ParteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente';
$this->params['breadcrumbs'][] = $this->title;
$precepx = Yii::$app->user->identity->username;

?>
<div class="parte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('Nuevo parte docente', 'index.php?r=parte/create', 
            [
             'class' => 'btn btn-success',
             'data' => [
                        'method' => 'post',
                        'params' => ['precepx' => $precepx], // <- extra level
            ],
            
            ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            
            if ($model->fecha == date('Y-m-d')){
                return ['class' => 'info', 'style'=>"font-weight:bold"];
            }
            return ['class' => 'warning'];
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model->fecha == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model->fecha, 'dd-MM-yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model->fecha, 'dd-MM-yyyy');
                }
            ],
            [   
                'label' => 'Preceptoria',
                'attribute' => 'preceptoria',
                'value' => 'preceptoria0.nombre',
                'filter' => ['M2P' => 'M2P', 'M1P' => 'M1P', 'MPB' => 'MPB', 'T2P' => 'T2P', 'T1P' => 'T1P', 'TPB' => 'TPB'],
                'filterInputOptions' => ['prompt' => 'Todas', 'class' => 'form-control', 'id' => null]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
