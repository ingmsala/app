<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorariogymSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horariogyms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariogym-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horariogym', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'División',
                'value' => function($model){
                    return $model->division0->nombre;
                }
            ],
            [
                'label' => 'Dia de la semana',
                'value' => function($model){
                    return $model->diasemana0->nombre;
                }
            ],
            
            'horario',
            'docentes',
            [
                'label' => 'Periodo',
                'value' => function($model){
                    if($model->repite == 1)
                        return 'Semanal';
                    else
                        return 'Cada 15 días';
                }
            ],
            [
                'label' => 'Periodo',
                'value' => function($model){
                    if($model->burbuja == 1)
                        return 'Amarilla';
                    elseif($model->burbuja == 2)
                        return 'Naranja';
                    else
                        return 'Intercalada';
                }
            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
