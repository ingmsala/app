<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CatedradeplanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catedradeplans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedradeplan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Catedradeplan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'catedra',
            'plan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
