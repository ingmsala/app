<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\InasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inasistencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inasistencia-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Inasistencia', ['/optativas/inasistencia/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'matricula',
            'clase',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
