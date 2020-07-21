<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Datos de Contacto de Emergencia';

?>


<div class="matricula-index">


    
<?php 


Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid',
        
        
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
                'label' => 'Alumno',
                'contentOptions' => [
                            'style' =>
                            ['height' => '20px', 'padding' => '0px'],
                        ],
                'group' => true,
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
                
            ],
            

            [
                'label' => 'Mail del Tutor',
                'format' => 'raw',
                'value' => function($model){

                     return $model['mail'];
                    
                    $itemsc = [];
                    return var_dump($model);
        
                    foreach($model->alumno0->tutors as $contacto){
                        
                        $itemsc[] = [$contacto->apellido, $contacto->nombre, $contacto->parentesco, $contacto->mail];
                        
                    }
                    
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                            
                                return 
                                        Html::tag('li', 
                                        $item[3], ['class' => 'list-group-item list-group-item-success']);
                        }
                    , 'class' => "nav nav-pills nav-stacked"]);                  
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    return $model->alumno0->dni;
                }
                
            ],

            


                        
           
        ],
        'pjax' => true,
    ]);

Pjax::end();
 ?>

    
</div>
