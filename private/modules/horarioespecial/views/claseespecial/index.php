<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horarioespecial\models\ClaseespecialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Claseespecials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claseespecial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Claseespecial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'horarioclaseespecial',
            'fecha',
            'aula',
            'detallecatedra',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
