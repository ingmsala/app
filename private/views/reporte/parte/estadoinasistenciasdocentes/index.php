<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AgenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Estado de Justificación de Inasistencias';


?>
<div class="agente-index">

    

    

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
        echo "<div id='modalContentGrafico'></div>";
        echo "<div id='modalContentGrafico2'></div>";

        Modal::end();
    ?>

     <?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',]; 

      $years2=ArrayHelper::map($years,'nombre','nombre'); ?>

     <?= Html::beginForm(); ?>
     <div class="form-group col-xs-2 .col-sm-3">
         <label for="cmbyear">Año</label> 
     <?= Html::dropDownList('year', $selection=$anio, $years2, ['prompt' => '(Año)', 'id' => 'cmbyear', 'class' => 'form-control ',   'required' => true,
        'onchange'=>'
                    var aniojs = document.getElementById("cmbyear").value;
                    
        
                    var url = "index.php?r=reporte/parte/estadoinasistenciasdocentes&anio=" + aniojs;
                    document.getElementById("btnfiltrar").href = url;

        ',


        ]);?>

    </div> 
    
    </div>
    
    <div class="form-group">
        <label for="btnfiltrar" style='color: #ffffff'>.</label><br />
        <?php
            
         echo Html::a('<span class="glyphicon glyphicon-filter" aria-hidden="true"></span>', '', ['id' => 'btnfiltrar', 'class' => 'btn btn-primary']); 
           
         ?>

    </div>
    
  <?= Html::endForm(); ?>

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
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
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => 'Agente',
                //'attribute' => 'agente
                'value' => function($model){
                    //return var_dump($model);
                     return $model['apellido'].', '.$model['nombre'];


                }
                            
            ],

            [
                'label' => 'Justificadas',
                //'attribute' => 'agente',
                'value' => function($model){
                    //return var_dump($model);
                     return $model['estadoinasistencia'];


                }
                            
            ],

            [
                'label' => 'Total',
                //'attribute' => 'agentefaltas',
                'value' => function($model){
                    //return var_dump($model);
                     return $model['id'];


                }
                            
            ],

            //'agente.apellido',
            //'agente.nombre',
/*
            [
            	'label' => 'Horas sin dictar',
            	//'attribute' => 'agente.faltas',
                'value' => function($model){
                    return var_dump($model);
                    $horas = $model['faltas']/40;
                    $minutos = ($horas-intval($horas))*40;
                    return intval($horas).'h:'.$minutos;


                }
                        	
            ],*/
           

            /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key) use ($anio, $mes){
                        
                       return $model['id'] != '' ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/parte/faltasdocentes/view&id='.$model['id'].'&anio='.$anio.'&mes='.$mes),
                                'class' => 'modalaReporteFaltasDocentes btn btn-link']) : '';

                                

                    },
                    
                ]

            ],*/
        ],
    ]); ?>


</div>

<?php 

    $this->registerJs('
         $("#btnfiltrar").click(function(){
            var aniojs = document.getElementById("cmbyear").value;
                    var mesjs = document.getElementById("cmbmes").value;
                    var docjs = document.getElementById("cmbdoc").value;
                    
                    var url = "index.php?r=reporte/parte/estadoinasistenciasdocentes&anio=" + aniojs;
            document.getElementById("btnfiltrar").href = url;
    });'

     );

?>