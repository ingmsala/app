<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadnooficialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividadnooficials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividadnooficial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Actividadnooficial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'empleador',
            'lugar',
            'sueldo',
            'ingreso',
            //'funcion',
            //'declaracionjurada',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
