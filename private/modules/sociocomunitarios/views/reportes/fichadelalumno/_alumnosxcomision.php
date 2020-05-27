<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ficha del Estudiante';

?>



<div class="matricula-index">





    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        'floatHeader'=>true,
        
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
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir todos', Url::to(['all', 'comision' => $comision]), ['class' => 'btn btn-default'])

            ],
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
                'label' => 'División secundario',
                'value' => function($matricula){
                    try{
                         return $matricula->division0->nombre;
                     }catch (\Exception $e){
                        return "";
                     }
                   
                }
            ],

            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => 'Matrícula',
                'attribute' => 'estadomatricula0.nombre',
                
            ],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=sociocomunitarios/reportes/fichadelalumno/view&id='.$model->id);
                    },
                    
                ]

            ],
                        
           
        ],
        
    ]);


 ?>

    
</div>
