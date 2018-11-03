<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Revistas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revista-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Revista', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           

            'id',
            'nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
