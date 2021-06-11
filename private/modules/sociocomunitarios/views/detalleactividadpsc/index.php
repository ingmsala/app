<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sociocomunitarios\models\DetalleactividadpscSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalleactividadpscs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleactividadpsc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Detalleactividadpsc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'actividad',
            'matricula',
            'presentacion',
            'calificacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
