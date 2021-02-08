<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\ActorxactuacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actorxactuacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actorxactuacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Actorxactuacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'persona',
            'actuacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
