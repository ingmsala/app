<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\DetalleplancursadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalleplancursados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleplancursado-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Detalleplancursado', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion:ntext',
            'catedra',
            'estadodetplan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
