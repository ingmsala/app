<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preceptores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revista-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           

            'id',
            [
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido',
            ],

            [
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre',
            ],

            [
                'label' => 'Revista',
                'attribute' => 'revista0.nombre',
            ],

            [
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre', 
            ],

            [
                'label' => 'División',
                'attribute' => 'division0.nombre',
            ],

             [
                'label' => 'Suplente',
                'attribute' => 'suplente0.docente0.apellido',
            ],


            
            
            
            
            

            
        ],
    ]); ?>
</div>