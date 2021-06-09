<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\desarrollo\DetalledesarrolloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalledesarrollos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalledesarrollo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Detalledesarrollo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'temaunidad',
            'estado',
            'desarrollo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
