<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\TipoplancursadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo de plan de cursado';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoplancursado-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Tipoplancursado', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
