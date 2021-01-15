<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\MatriculaedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matriculaedhs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matriculaedh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Matriculaedh', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alumno0.apellido',
            'division0.nombre',
            'aniolectivo0.nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
