<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Horas sin dictar por Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

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

     $years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023']; ?>

     <?= Html::beginForm(); ?>
     <div class="form-group col-xs-4 .col-sm-3">
         <label for="cmbyear">Año</label> 
     <?= Html::dropDownList('year', $selection=$anio, $years, ['prompt' => '(Año)', 'id' => 'cmbyear', 'class' => 'form-control ',
        'onchange'=>'
                    var aniojs = document.getElementById("cmbyear").value;
                                var mesjs = document.getElementById("cmbmes").value;
                                
                                var url = "index.php?r=reporte/parte/faltasdocentes&mes=" + mesjs + "&anio=" + aniojs;
                                document.getElementById("btnfiltrar").href = url;

        ',


        ]);?>

    </div> 
    <div class="form-group col-xs-4 .col-sm-3">
         <label for="cmbmes">Mes</label> 
     <?= 
      
     Html::dropDownList('mes', $selection= $mes, $meses, ['prompt' => '(Todos)', 'id' => 'cmbmes', 'class' => 'form-control',
        'onchange'=>'
                    var aniojs = document.getElementById("cmbyear").value;
                                var mesjs = document.getElementById("cmbmes").value;
                                
                                var url = "index.php?r=reporte/parte/faltasdocentes&mes=" + mesjs + "&anio=" + aniojs;
                                document.getElementById("btnfiltrar").href = url;

        ',
        ]);?>
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
        'filterModel' => $searchModel,
        'columns' => [
            
            
            'legajo',
            'apellido',
            'nombre',

            [
            	'label' => 'Horas sin dictar',
            	'attribute' => 'faltas',
                'value' => function($model){

                    $horas = $model['faltas']/40;
                    $minutos = ($horas-intval($horas))*40;
                    return intval($horas).'h:'.$minutos;


                }
                        	
            ],
           

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key) use ($anio, $mes){
                        
                       return $model['id'] != '' ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/parte/faltasdocentes/view&id='.$model['id'].'&anio='.$anio.'&mes='.$mes),
                                'class' => 'modalaReporteFaltasDocentes btn btn-link']) : '';

                                

                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>