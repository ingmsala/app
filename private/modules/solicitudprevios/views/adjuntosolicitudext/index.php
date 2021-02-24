<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\solicitudprevios\models\AdjuntosolicitudextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjuntosolicitudexts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjuntosolicitudext-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adjuntosolicitudext', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'url:url',
            'solicitud',
            'nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
