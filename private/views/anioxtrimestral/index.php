<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnioxtrimestralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trimestral por año';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anioxtrimestral-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Trimestral', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'aniolectivo0.nombre',
            'trimestral0.nombre',
            [
                'label' => 'Inicio',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy');
                 
                }
            ],
            [
                'label' => 'Fin',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return ($model->activo==1) ? 'Activo' : 'Inactivo';
                }
            ],
            [
                'label' => 'Publicado?',
                'value' => function($model){
                    return ($model->publicado==1) ? 'Sí' : 'No';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
