<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sociocomunitarios\models\RubricaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rubricas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rubrica-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Rubrica', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion:ntext',
            'curso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
