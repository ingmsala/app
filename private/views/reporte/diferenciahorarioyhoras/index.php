<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Diferencia de Horas de la materia vs Horario';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

      

    

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,

            'heading' => Html::encode($this->title)
            
            ],

         'toolbar'=>[
            
            '{export}',
            
        ],
        'floatHeader'=>true,
        'summary'=>false,
        'exportConfig' => [
            
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

        'columns' => [
            
            
            //'id',
            'division',
            'materia',
            [
                'label' => 'Horas de la Materia',
                'value' => function($model){
                    return $model['horasmat'];
                }
            ],
            [
                'label' => 'Cant. en el horario',
                'value' => function($model){
                    return $model['horashorario'];
                }
            ],
            
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'hiddenFromExport' => true,
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                '?r=horario/completoxcurso&division='.$model['divid'].'&vista=docentes');


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>