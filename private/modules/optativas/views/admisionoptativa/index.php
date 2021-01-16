<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\AdmisionoptativaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admisiones: Espacios Optativos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admisionoptativa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Admisión', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'alumno0.apellido',
            'alumno0.nombre',
            'alumno0.documento',
            'curso',
            'aniolectivo0.nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
