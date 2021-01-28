<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\EstadocasoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado de casos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadocaso-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Estado', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

            ['class' => 'yii\grid\ActionColumn', 

'template' => '{update} {view}'
            ],

        ],
    ]); ?>
</div>
