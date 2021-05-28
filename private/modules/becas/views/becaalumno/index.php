<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecaalumnoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becaalumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaalumno-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Becaalumno', ['create'], ['class' => 'btn btn-success']) ?>
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
            'mail',
            //'telefono',
            //'fechanac',
            //'domicilio',
            //'nivelestudio',
            //'negativaanses',
            //'persona',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
