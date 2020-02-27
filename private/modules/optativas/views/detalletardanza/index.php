<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\DetalletardanzaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalletardanzas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalletardanza-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Detalletardanza', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'matricula',
            'clase',
            'tardanza',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
