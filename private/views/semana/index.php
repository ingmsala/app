<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SemanaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semanas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semana-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Semana', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'aniolectivo',
            'inicio',
            'fin',
            'publicada',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
