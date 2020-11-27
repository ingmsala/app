<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\mones\models\MonmateriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monmaterias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monmateria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Monmateria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'codmon',
            'carrera',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
