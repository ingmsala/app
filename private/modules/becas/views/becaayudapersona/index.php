<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecaayudapersonaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becaayudapersonas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaayudapersona-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Becaayudapersona', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'persona',
            'ayuda',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
