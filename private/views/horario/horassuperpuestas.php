<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes con horas superpuestas';

?>
<div class="horario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'apellido',
            'nombre',
           
            [
                'label' => 'Ver',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', $url = '?r=horario/completoxdocente&agente='.$model['id']);
                }
            ],
        ],
    ]); ?>
</div>