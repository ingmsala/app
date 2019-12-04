<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NodocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'No docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nodocente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'legajo',
            'documento',
            'apellido',
            'nombre',
            [
                'label' => "Género",
                'attribute' => 'genero0.nombre',
            ],
            'mail',
            
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
