<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Actividad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            

            'id',
            'nombre',
            'cantHoras',
            [
                'label' => 'Tipo de Actividad',
                'attribute' => 'actividadtipo',
                'value' => 'actividadtipo0.nombre'
            ],
            [
                'label' => 'Plan',
                'attribute' => 'plan',
                'value' => 'plan0.nombre'
            ],
            [
                'label' => 'Propuesta Formativa',
                'attribute' => 'propuesta',
                'value' => 'propuesta0.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
