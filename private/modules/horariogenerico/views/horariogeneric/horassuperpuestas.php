<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes con horas superpuestas - Horario Mixto';


?>
<div class="horario-index">


    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'apellido',
            'nombre',
            [
                'label' => 'Fecha',
                'value' => function($model){
                   date_default_timezone_set('America/Argentina/Buenos_Aires');
                   
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Hora',
                'value' => function($model){
                   return ($model['hora']+1).'°';
                }
            ],
           
            [
                'label' => 'Ver',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', $url = '?r=horariogenerico/horariogeneric/completoxdocente&agente='.$model['id']);
                }
            ],
        ],
    ]); ?>
</div>