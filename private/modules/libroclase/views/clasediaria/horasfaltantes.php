<?php

use kartik\grid\GridView;
use yii\helpers\Html;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\ClasediariaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="clasediaria-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'panel' => [
            'type' => GridView::TYPE_DANGER,
            'heading' => 'Clases sin completar el libro',
            'footer' => false,
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        
        'toolbar'=>[
            ['content' => ''],
        ],
        'columns' => [
            

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model) use($catedra){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['fecha'] == date('Y-m-d')){
                    return Html::a(Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy'), Url::to(['create', 'cat' => $catedra, 'fecha'=>$model['fecha']], $schema = true), $options = []).' (HOY)';
                   } 
                   return Html::a(Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy'), Url::to(['create', 'cat' => $catedra, 'fecha'=>$model['fecha']], $schema = true), $options = []);
                }
            ],
            
            
        ],
    ]); ?>
</div>
