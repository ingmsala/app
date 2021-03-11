<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClasevirtualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte por semana';

?>
<div class="clasevirtual-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            

            [
                'label' => 'División',
                //'attribute' => 'division',
                'group' => true,
                'value' => function($model){
                    return $model->division;
                }
            ],

            'diasemananombre',

            [
                'label' => 'Fecha',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                   return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            
            
           
            [
                'label' => 'Burbuja',
                //'attribute' => 'division',
                
                'value' => function($model){
                    return $model->burbujanombre;
                }
            ],

            [
                'label' => 'Cantidad de horas',
                //'attribute' => 'division',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->cant, Url::to(['/horariogenerico/horariogeneric/completoxcurso', 'division' => $model->divid, 'vista' => 'docentes', 'ini' => 1, 'sem' => $model->semana], $schema = true));
                }
            ],
            
            

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
