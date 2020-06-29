<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horarioespecial\models\HorarioclaseespecialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarioclaseespecials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horarioclaseespecial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Horarioclaseespecial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'inicio',
            'fin',
            'codigo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
