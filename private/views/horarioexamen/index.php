<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarioexamens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horarioexamen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horarioexamen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'catedra',
            'hora',
            'tipo',
            'anioxtrimestral',
            //'fecha',
            //'cambiada',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
