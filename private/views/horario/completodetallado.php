<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de docentes en horario';

?>
<div class="horario-index">

    
    <?php
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    ?>
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
            GridView::PDF => [
                'label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => ''],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
                
                //'alertMsg' => false,
            ],

            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' =>'Documento',
                //'group' => true,
                'value' => function($model){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6){
                            $doc = $dc->docente0->documento;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            [
                'label' =>'Docente',
                //'group' => true,
                'value' => function($model){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6){
                            $doc = $dc->docente0->apellido.', '.$dc->docente0->nombre;
                            break;
                        }
                    }
                    return $doc;
                }
            ],

            [
                'label' =>'Materia',
                //'group' => true,
                'attribute' => 'actividad0.nombre',
            ],
           
            [
                'label' => 'División',
                //'group' => true,
                'format' => 'raw',
                'value' => function($model){
                        
                            return $model->division0->nombre;
                         
                }

            ],

            [
                'label' =>'Docente',
                //'group' => true,
                'value' => function($model){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6){
                            $doc = $dc->docente0->mail;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            
            
            /*[
                'label' =>'',
                'group' => true,
                'attribute' => 'diasemana0.nombre',
            ],
            [
                'label' =>'',
                'attribute' => 'hora0.nombre',
            ],*/
            
            //'tipomovilidad0.nombre',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>