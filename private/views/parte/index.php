<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ParteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente';
$this->params['breadcrumbs'][] = $this->title;
$precepx = Yii::$app->user->identity->username;

?>
<div class="parte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('Nuevo parte docente', 'index.php?r=parte/create&precepx='.$precepx, ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                    $formatter = \Yii::$app->formatter;
                   return $formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [   
                'label' => 'Preceptoria',
                'attribute' => 'preceptoria',
                'value' => 'preceptoria0.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
