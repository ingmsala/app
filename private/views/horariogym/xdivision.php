<?php

use app\modules\horariogenerico\models\Horariogeneric;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\models\HorariogymSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horario de Educación Física';

?>
<div class="horariogym-index">

    <?php
    if($dataProvider != null)
     echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<center>'.Html::encode($this->title).'</center>',
            'footer' => false,
            'before' => false,
            'after'=>false,
        ],
        'summary' => false,

        

        'toolbar'=>[
            ['content' => 
                ''

            ],
            
            
        ],
        'rowOptions' => function($model, $key, $index, $grid) use($semana){
            if($model->repite == 2 && $semana->id%2!=0 && $model->burbuja == 1){
                return ['style' => 'visibility:collapse;'];
            }
            if($model->repite == 2 && $semana->id%2==0 && $model->burbuja == 2){
                return ['style' => 'visibility:collapse;'];
            }else {
                if($semana->tiposemana == null){
                    return ['style' => 'visibility:collapse;']; 
                }
                if($model->burbuja == 1)
                    return ['style' => 'visibility:visible;background-color:#FFFACD;'];
                if($model->burbuja == 2)
                    return ['style' => 'visibility:visible;background-color:#FFCD80;'];
                if($model->burbuja == 0){
                    if($semana->id%2!=0){
                        return ['style' => 'visibility:visible;background-color:#FFCD80;'];
                    }else{
                        return ['style' => 'visibility:visible;background-color:#FFFACD;'];
                    }
                }
            }
        },

        'columns' => [
            

            [
                'label' => 'División',
                'value' => function($model){
                    return $model->division0->nombre;
                }
            ],

            [
                'label' => 'Fecha',
                'value' => function($model) use($semana){
                    
                    try {
                        $fecha = $semana->fechas;
                        return $model->diasemana0->nombre.' '.Yii::$app->formatter->asDate($fecha[$model->diasemana], 'dd/MM');
                    } catch (\Throwable $th) {
                        return $model->diasemana0->nombre;
                    }
                    
                }
            ],
            [
                'label' => 'Horario',
                'value' => function($model){
                    return $model->horario;
                }
            ],
            [
                'label' => 'Docentes',
                'value' => function($model){
                    return $model->docentes;
                }
            ],
            
            [
                'label' => 'Burbuja',
                'value' => function($model) use($semana){

                    if($model->burbuja == 1){
                        return 'Amarilla';
                    }elseif($model->burbuja == 2)
                        return 'Naranja';
                    else{
                        if($model->repite == 2){
                            if($semana->id%2!=0){
                                return 'Naranja';
                            }else{
                                return 'Amarilla';
                            }
                        }
                    }

                    
                }
            ],
            
            
        ],
    ]); ?>
</div>
