<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\solicitudprevios\models\EstadodetallesolicitudextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estadodetallesolicitudexts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadodetallesolicitudext-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Estadodetallesolicitudext', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
