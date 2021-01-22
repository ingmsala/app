<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\EstadosolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado de solicitud';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadosolicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Estado de solicitud', ['create'], ['class' => 'btn btn-success']) ?>
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
