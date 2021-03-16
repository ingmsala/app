<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\HoraxclaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horaxclases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horaxclase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horaxclase', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'clasediaria',
            'hora',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
