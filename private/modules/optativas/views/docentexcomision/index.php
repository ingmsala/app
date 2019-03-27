<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\DocentexcomisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentexcomisions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentexcomision-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Docentexcomision', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'docente',
            'comision',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
