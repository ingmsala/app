<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horarioespecial\models\GrupodivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupodivisions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupodivision-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Grupodivision', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'habilitacionce',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
