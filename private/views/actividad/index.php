<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="actividad-index">

      

    <p>
        <?= Html::a('Nueva Actividad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'columns' => [
            

            'id',
            'nombre',
            'cantHoras',
            [
                'label' => 'Tipo de Actividad',
                'attribute' => 'actividadtipo',
                'value' => 'actividadtipo0.nombre'
            ],
            [
                'label' => 'Plan',
                'attribute' => 'plan',
                'value' => 'plan0.nombre'
            ],
            [
                'label' => 'Propuesta Formativa',
                'attribute' => 'propuesta',
                'value' => 'propuesta0.nombre'
            ],
            [
                'label' => 'Departamento',
                'attribute' => 'departamento',
                'value' => 'departamento0.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
