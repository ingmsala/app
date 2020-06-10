<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorariodjSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horariodjs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariodj-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Horariodj', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'diasemana',
            'inicio',
            'fin',
            'funciondj',
            //'actividadnooficial',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
