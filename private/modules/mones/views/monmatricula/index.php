<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\mones\models\MonmatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monmatriculas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monmatricula-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Monmatricula', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alumno',
            'carrera',
            'certificado',
            'libro',
            //'folio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
