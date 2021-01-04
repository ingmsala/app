<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\AsignacionticketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignaciontickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignacionticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Asignacionticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'agente',
            'areaticket',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
