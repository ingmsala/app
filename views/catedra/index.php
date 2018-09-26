<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catedras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Catedra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            

            'id',
            [   
                'label' => 'Actividad',
                'attribute' => 'actividad',
                'value' => 'actividad0.nombre'
            ],
            [   
                'label' => 'Division',
                'attribute' => 'division',
                'value' => 'division0.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


