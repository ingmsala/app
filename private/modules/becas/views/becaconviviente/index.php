<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecaconvivienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becaconvivientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaconviviente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Becaconviviente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'apellido',
            'nombre',
            'cuil',
            'fechanac',
            //'nivelestudio',
            //'negativaanses',
            //'parentesco',
            //'solicitud',
            //'persona',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
