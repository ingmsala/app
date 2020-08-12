<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\ClasediariaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libro de aula';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasediaria-index">

    <h1><?= $division->nombre ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva clase diaria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'catedra',
            'temaunidad',
            'tipodesarrollo',
            'fecha',
            //'fechacarga',
            //'docente',
            //'observaciones:ntext',
            //'modalidadclase',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
