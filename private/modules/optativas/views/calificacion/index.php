<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\CalificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Calificacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha',
            'matricula',
            'calificacion',
            'estadocalificacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
