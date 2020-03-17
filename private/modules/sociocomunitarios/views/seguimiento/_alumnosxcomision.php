<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seguimiento';

?>

<?php $listSeguimientos=ArrayHelper::map($seguimientos,'id','matricula'); 



$cantidades = array_count_values($listSeguimientos);

?>



<div class="matricula-index">

    
<?php 


Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    
    <?= 

    GridView::widget([
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
            
            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => '',
                'attribute' => 'estadomatricula0.nombre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'hiddenFromExport' => true,
                'value' => function($model) use($cantidades){
                    
                    
                    try{
                        $i = $cantidades[$model->id];
                        return '<span style="color:green;" class="glyphicon glyphicon-record"></span>';
                    }catch(\Exception $exception){
                        return '<span style="color:red;" class="glyphicon glyphicon-record"></span>';
                    }
                    
                    
                }
                
            ],
            [
                'label' => 'Cantidad',
                'attribute' => 'estadomatricula0.nombre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model) use($cantidades){
                    
                    
                    try{
                        return $cantidades[$model->id];
                    }catch(\Exception $exception){
                        return 0;
                    }
                    
                    
                }
                
            ],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=sociocomunitarios/seguimiento/view&id='.$model->id);
                    },
                    
                ]

            ],
            
                        
           
        ],
        //'pjax' => true,
    ]);

Pjax::end();
 ?>

    
</div>
