<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\AreasolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Área de solicitud';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areasolicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva área', ['create'], ['class' => 'btn btn-success']) ?>
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
