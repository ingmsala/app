<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\MatriculaedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matriculaedh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva matrícula', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->alumno0->nombrecompleto;
                }
            ],
            [
                'label' => 'División',
                'value' => function($model){
                    return $model->division0->nombre;
                }
            ],
            [
                'label' => 'Año lectivo',
                'value' => function($model){
                    return $model->aniolectivo0->nombre;
                }
            ],
            

            ['class' => 'yii\grid\ActionColumn', 

'template' => '{update} {view}'
            ],

        ],
    ]); ?>
</div>
