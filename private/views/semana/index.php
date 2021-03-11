<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SemanaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semanas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semana-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-6">
        <div>
            <?= edofre\fullcalendar\Fullcalendar::widget([
                'header'        => [
                    'left'   => 'today prev,next',
                    'center' => 'title',
                    'right'  => 'timelineDay,timelineThreeDays',
                ],
                'events'        => $events,
                'clientOptions' => [
                    
                    //'aspectRatio'       => 1.5,
                    
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <?=$renderMasivos;?>
        <div class="clearfix"></div>
        <?=$renderCopiarDesde;?>
    </div>
    <?php
     /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            
            $hoy = strtotime(date('Y-m-d'));

            $domingosemanamodel = strtotime("+ 2 day", strtotime($model->fin));

            if($hoy>=strtotime($model->inicio) && $hoy<=$domingosemanamodel){
                return ['class' => 'success', 'id' => $model->id];
            }
            
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Año lectivo',
                'value' => function($model){
                    return $model->aniolectivo0->nombre;
                }
            ],
            [
                'label' => 'Duracion',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                    return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy').' al '.Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Tipo',
                'value' => function($model){
                        try {
                            return $model->tiposemana0->nombre;
                        } catch (\Throwable $th) {
                            return '';
                        }           
                   
                    
                }
            ],
            [
                'label' => 'Publicada en horario',
                'value' => function($model){
                    return ($model->publicada == 0) ? 'No' : 'Sí';
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>
</div>
