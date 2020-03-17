<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\EspaciocurricularSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Espacios Optativos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="optativa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Espaciocurricular', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'actividad0.nombre',
            'aniolectivo0.nombre',
            'duracion',
            [
                'label' => 'Área de Espaciocurricular' , 
                'attribute' => 'areaoptativa0.nombre',
            ],
            'curso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
