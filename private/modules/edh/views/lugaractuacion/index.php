<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\LugaractuacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lugar de actuación';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lugaractuacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Lugar de actuación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

            ['class' => 'yii\grid\ActionColumn', 
            'template' => '{view} {update}'],
        ],
    ]); ?>
</div>
