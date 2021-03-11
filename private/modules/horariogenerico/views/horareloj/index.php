<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horariogenerico\models\HorarelojSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarelojs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horareloj-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horareloj', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'hora',
            'anio',
            'turno',
            'semana',
            //'inicio',
            //'fin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
