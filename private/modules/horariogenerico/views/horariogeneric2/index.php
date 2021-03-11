<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horariogenerico\models\HorariogenericSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horariogenerics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariogeneric-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horariogeneric', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'catedra',
            'horareloj',
            'semana',
            'fecha',
            //'burbuja',
            //'aniolectivo',
            //'diasemana',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
