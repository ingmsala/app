<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matricula-index">

    

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
                Html::a('Nueva Inscripción', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['optativa0']['aniolectivo0']['nombre'].' - '.$model['comision0']['optativa0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'];
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],

            [
                'label' => 'Fecha Inscripción',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            'alumno0.dni',
            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => 'Estado',
                'attribute' => 'estadomatricula0.nombre',
                
            ],
                        
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
