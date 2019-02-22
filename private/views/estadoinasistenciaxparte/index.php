<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadoinasistenciaxparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estadoinasistenciaxpartes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoinasistenciaxparte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Estadoinasistenciaxparte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'detalle',
            'estadoinasistencia',
            'fecha',
            'detalleparte',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
