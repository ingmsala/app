<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilla de Asistencia';

?>


<div class="matricula-index">


    
<?php 


Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        'responsiveWrap' => false,
        
        
        //'filterModel' => $searchModel,
        
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            
            '{export}',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            /*[
                'label' => 'Optativa',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['optativa0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'];
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],*/

            [
                'label' => 'Alumno',
                'contentOptions' => [
                            'style' =>
                            ['height' => '20px', 'padding' => '0px'],
                        ],
                'value' => function($model){
                    return $model->alumno0->apellido.', '.$model->alumno0->nombre;
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],
            [
                'label' => '',
                'value' => function(){
                    return '';
                }
                
            ],



                        
           
        ],
        'pjax' => true,
    ]);

Pjax::end();
 ?>

    
</div>
