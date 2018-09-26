<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleCatedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalle Catedras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-catedra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Detalle de Catedra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'docente',
            'catedra',
            'condicion',
            'revista',
            //'resolucion',
            //'fechaInicio',
            //'fechaFin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
