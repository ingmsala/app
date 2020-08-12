<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\DetalleunidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalleunidads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleunidad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Detalleunidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'unidad',
            'programa',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
