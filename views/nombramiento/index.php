<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NombramientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nombramientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nombramiento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Nombramiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        
            [
                'label' => 'Cod. Cargo',
                'attribute' => 'cargo',
                'value' => 'cargo',
            ],
            [
                'label' => 'Cargo',
                'attribute' => 'cargo0.nombre',
                
            ],
            [
                'label' => 'Apellido',
                'attribute' => 'docente',
                'value' => 'docente0.apellido',
            ],
            [
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre',
                
            ],
            'nombre',
            'horas',
            [
                'label' => 'Revista',
                'attribute' => 'revista',
                'value' => 'revista0.nombre',
            ],
            
            
            
            [
                'label' => 'Division',
                'attribute' => 'division',
                'value' => 'division0.nombre',
            ],
            [
                'label' => 'Suplente',
                'attribute' => 'suplente',
                'value' => 'suplente0.docente0.apellido',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
