<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ClaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';

?>
<div class="clase-index" style="margin-top: 20px;">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
        'toolbar'=>[
            ['content' => 
                Html::a('Nueva Clase', ['create'], ['class' => 'btn btn-success'])
            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            'tema',
            [
                'label' => 'Comisión',
                'attribute' => 'comision0.nombre',
            ],
            [
                'label' => 'Tipo de Clase',
                'attribute' => 'tipoclase0.nombre',
            ],
            'horascatedra',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 


   

    ?>


    


</div>
