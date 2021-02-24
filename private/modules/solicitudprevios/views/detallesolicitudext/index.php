<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\solicitudprevios\models\DetallesolicitudextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes: '.$turno->nombre;

?>
<div class="detallesolicitudext-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'config' => [
                    'worksheet' => Html::encode($this->title),
            
                ]
            ],
            //GridView::HTML => [// html settings],
            GridView::PDF => ['label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => 'Portable Document Format'],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
            ],
        ],

        'toolbar'=>[
            ['content' => 
               ''

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Materia',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->actividad0->nombre;
                },
                'group' => true,  // enable grouping,
                //'groupedRow' => true,                    // move grouped column to a single grouped row
                //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],
            
            [
                'label' => 'Estudiante',
                
                'value' => function($model){
                    //return var_dump($model);
                    return $model->solicitud0->apellido.', '.$model->solicitud0->nombre;
                },
                
                
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
