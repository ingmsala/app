<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Divisiones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Division', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            

            'id',
            'nombre',
            
            [   
                'label' => 'Propuesta Formativa',
                'attribute' => 'propuesta',
                'value' => 'propuesta0.nombre'
            ],

            [   
                'label' => 'Turno',
                'attribute' => 'turno',
                'value' => 'turno0.nombre'
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
