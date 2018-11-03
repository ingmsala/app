<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Docente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            
            'legajo',
            'apellido',
            'nombre',
            [
                'label' => 'Género',
                'attribute' => 'genero',
                'value' => function($model){

                   return $model->genero0->nombre;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
