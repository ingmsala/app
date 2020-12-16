<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use app\config\Globales;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Estadonovedad;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alumnos ausentes a Exámenes trimestrales';
$listestados=ArrayHelper::map($estados,'id','nombre');
?>


<div class="detalleparte-index">

    
     <?= $this->render('_filter', [
        'model' => $model,
        'trimestrales' => $trimestrales,
        'aniolectivo' => $aniolectivo,
        'estados' => $estados,
        'param' => $param,
        'collapse' => $collapse,
        'preceptorias' => $preceptorias,
        
    ]) ?>

  <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>

    <?php 
if($collapse=="")
echo GridView::widget([
        'id' => 'grid',
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
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

        //'filterModel' => $searchModel,
        'columns' => [
            
          /* [
                'format' => 'raw',
                'label' => '',
                //'attribute' => 'estadonovedad0.nombre',
                'hiddenFromExport' => true,
                'value' => function($model){
                    $itemsc = [];
                    
                    $formatter = \Yii::$app->formatter;
       
                    foreach($model->estadoxnovedads as $estadoxnovedad){
                        
                        $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                        
                    }
                    
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                                if($item[1]=='Activo')
                                    $boots='info';
                                elseif($item[1]=='En proceso')
                                    $boots='warning';
                                elseif($item[1]=='Rechazado')
                                    $boots='danger';
                                elseif($item[1]=='Presentó nota - Pendiente de revisión')
                                    $boots='warning';
                                else
                                    $boots='success';
                                return 
                                        Html::tag('li', 
                                        $item[0].' - '.$item[1], ['class' => 'list-group-item list-group-item-'.$boots]);
                        }
                    , 'class' => "nav nav-pills nav-stacked"]);                  
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    //return $model->alumno0->dni;
                }
            ],*/
           [   
                'label' => 'Fecha',
                'attribute' => 'novedadesparte0.parte0.fecha',
               
                'value' => function($model){
                    //var_dump($model);
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model->novedadesparte0->parte0->fecha, 'dd/MM/yyyy');
                    
                }
            ],
            [

                'label' => 'Preceptoria',
                'attribute' => 'novedadesparte0.parte0.preceptoria0.nombre',

            ],

            [

                'label' => 'Tipo de Novedad',
                'attribute' => 'novedadesparte0.tiponovedad0.nombre',
            ],

            [

                'label' => 'Descripcion',
                'attribute' => 'novedadesparte',
                'value' => function($model){
                        return $model->novedadesparte0->descripcion;
                }
            ],

            
            
            [
                'format' => 'raw',
                'label' => 'Presenta Nota',
                'attribute' => 'estadonovedad',
                'width'=>'20%',
                'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $listestados, 
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Todos'], // allows multiple authors to be chosen
    
                'value' => function($model){
                    //return $model->id;
                    //$np =  Estadoxnovedad::find()->where(['id' => $model->id])->one();
                    try {
                       if($model->novedadesparte0->estadoxnovedads[2]->estadonovedad == 6){
                            return "Sí";
                        }else{
                            return "No";
                        } 
                    } catch (Exception $e) {
                        return "No";
                    }
                        
                },
            ],

            [
                'format' => 'raw',
                'label' => 'Estado',
                //'attribute' => 'activo',
                'width'=>'20%',
                'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $listestados, 
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Todos'], // allows multiple authors to be chosen
    
                'value' => function($model){
                    //return var_dump($model->estadonovedad);
                    $np =  Estadonovedad::find()->where(['orderstate' => $model->estadonovedad])->one();
                        return $np->nombre;//$model['estadonovedad0']['nombre'];
                },
            ],

           
            
            
        ],
        
]);



    
 ?>

 <?php Pjax::end(); ?>
</div>
