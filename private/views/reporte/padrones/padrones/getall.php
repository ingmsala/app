<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Padrón Docente - Por Agente';

?>

<div class="padron-index">

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'floatHeader'=>true,
        'condensed'=>true,
        'floatOverflowContainer'=>true,
        //'perfectScrollbar'=>true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],

        ],

        'beforeHeader' => [
            [
                'columns' => [
                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                    ['content' => 'Secundario', 'options' => ['colspan' => 4, 'class' => 'text-center info']],
                    ['content' => 'Pregrado', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
                ],
            ]
        ],

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            
            '{export}',
            
        ],
        'columns' => [
           

            [
                'label' => 'Agente',
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
            ],

            [
                'label' => 'Profesor',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['docente_secundario'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Preceptor',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['preceptor_secundario'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Jefe',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['jefe_secundario'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Otros docentes',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['otros_secundario'] == 0) ? '' : 'Sí';                
                }
            ],

             [
                'label' => 'Profesor',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['docente_pregrado'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Preceptor',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['preceptor_pregrado'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Jefe',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['jefe_pregrado'] == 0) ? '' : 'Sí';                
                }
            ],

            [
                'label' => 'Otros Docentes',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) {
                    return ($model['otros_pregrado'] == 0) ? '' : 'Sí';                
                }
            ],

                       
            
            
            
            

            
        ],
    ]); ?>
</div>