<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\TipoparticipanteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo de participante';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoparticipante-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Tipo de participante', ['create'], ['class' => 'btn btn-success']) ?>
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