<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecasolicitanteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becasolicitantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becasolicitante-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Becasolicitante', ['create'], ['class' => 'btn btn-success']) ?>
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
            //'parentesco',
            //'nivelestudio',
            //'negativaanses',
            //'persona',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
