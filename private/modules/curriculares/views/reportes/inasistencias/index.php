<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inasistencias por división de Secundario';

?>


<div class="matricula-index">

<?= $this->render('_filter', [
        'model' => $model,

        'aniolectivos' => $aniolectivos,
        'divisiones' => $divisiones,
        'param' => $param,
    
        
    ]) ?>


    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        'rowOptions' => function($model){
            
                        
            if (round($model['horasfalta']*100/$model['horascatededra'],2) >20){
                return ['class' => 'warning', 'style'=>"font-weight:bold"];
            }
            //return ['class' => 'warning'];
        },
        
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
            
            '{export}',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            /*[
                'label' => 'Espaciocurricular',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['espaciocurricular0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'];
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],*/

            [
                'label' => 'Division',
                
                'value' => function($model){
                    return $model['division'];
                }
                
            ],

            [
                'label' => 'Alumno',
                
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
                
            ],
            [
                'label' => 'Actividad',
                
                'value' => function($model){
                    return $model['actividad'];
                }
                
            ],

            [
                'label' => 'Cant. Inasistencias',
                
                'value' => function($model){
                    return $model['inasistencias'];
                }
                
            ],

            [
                'header' => '% de horas <br /> Inasistencias '.'<span data-toggle="tooltip" title="% de inasistencias respecto al total de la Espaciocurricular" class="glyphicon glyphicon-info-sign"></span>',
                
                'value' => function($model){
                    return round($model['horasfalta']*100/$model['horascatededra'],2).'%';
                }
                
            ],
      

            


                        
           
        ],
       
    ]);


 ?>

    
</div>
