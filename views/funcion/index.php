<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FuncionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Funcions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Funcion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            [   
                'label' => 'Cargo',
                'attribute' => 'cargo',
                'value' => 'cargo0.nombre'
            ],
            'horas',
            [   
                'label' => 'Docente',
                'attribute' => 'docente',
                'value' => function ($data)
                            {
                              return $data->docente0->apellido.', '.$data->docente0->nombre;
                            }
                
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
