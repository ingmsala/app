<?php

use app\config\Globales;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecaconvocatoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Convocatorias a becas';

?>
<div class="becaconvocatoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER])){
            echo Html::a('Nueva Convocatoria', ['create'], ['class' => 'btn btn-success']);
            $template = '{view} {update} {delete}';
        }else{
            $template = '{view}';
        }
         ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'aniolectivo0.nombre',
            [
                'label' => 'Desde',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model->desde == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model->desde, 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model->desde, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model->hasta == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model->hasta, 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model->hasta, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Estado',
                'attribute' => 'becaconvocatoriaestado0.nombre',
            ],
            
            //'becatipobeca',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $template,
            ],
        ],
    ]); ?>
</div>
