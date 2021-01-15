<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CasoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Casos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caso-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva solicitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Inicio',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Fin',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
                }
            ],
            'resolucion',
            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;
                }
            ],
            [
                'label' => 'Condición final',
                'value' => function($model){
                    return $model->condicionfinal0->nombre;
                }
            ],
            [
                'label' => 'Estado caso',
                'value' => function($model){
                    return $model->estadocaso0->nombre;
                }
            ],
            
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
