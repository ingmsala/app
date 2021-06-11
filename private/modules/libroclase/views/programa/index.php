<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\ProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Programa', ['create', 'ac' => $actividad], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'plan0.nombre',
            'actividad0.nombre',
            [
                'label' => 'Vigencia',
                'value' => function ($model){
                    return ($model->vigencia == 1) ? 'Vigente' : 'Inactivo';
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
