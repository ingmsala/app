<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\Highcharts;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Distribución de faltas por día y hora';
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
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
    <?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',]; 

     $years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023'];

     $turnos = [ 1 => 'Mañana', 2 => 'Tarde']; ?>

     <?= Html::beginForm(); ?>
     <div class="form-group col-xs-3 .col-sm-3">
      <label for="cmbyear">Año</label>  
     <?= Html::dropDownList('year', $selection=$anio, $years, ['prompt' => '(Año)', 'id' => 'cmbyear', 'class' => 'form-control ',
        'onchange'=>'
                                var aniojs = document.getElementById("cmbyear").value;
                                var mesjs = document.getElementById("cmbmes").value;
                                var turnojs = document.getElementById("cmbturno").value;
                                
                                var url = "index.php?r=reporte/parte/distribuciondediasyhoras&mes=" + mesjs + "&anio=" + aniojs + "&turno=" + turnojs;
                                document.getElementById("btnfiltrar").href = url;

        ',


        ]);?>

    </div> 
    <div class="form-group col-xs-3 .col-sm-3"> 
        <label for="cmbmes">Mes</label>
     <?= 
    
     Html::dropDownList('mes', $selection= $mes, $meses, ['prompt' => '(Todos)', 'id' => 'cmbmes', 'class' => 'form-control',
        'onchange'=>'
                                var aniojs = document.getElementById("cmbyear").value;
                                var mesjs = document.getElementById("cmbmes").value;
                                var turnojs = document.getElementById("cmbturno").value;
                                
                                var url = "index.php?r=reporte/parte/distribuciondediasyhoras&mes=" + mesjs + "&anio=" + aniojs + "&turno=" + turnojs;
                                document.getElementById("btnfiltrar").href = url;
        ',
        ]);?>
    </div>

    <div class="form-group col-xs-3 .col-sm-3">
        <label for="cmbturno">Turno</label>
     <?= Html::dropDownList('turn', $selection=$turno, $turnos, ['prompt' => '(Todos)', 'id' => 'cmbturno', 'class' => 'form-control ',
        'onchange'=>'
                                var aniojs = document.getElementById("cmbyear").value;
                                var mesjs = document.getElementById("cmbmes").value;
                                var turnojs = document.getElementById("cmbturno").value;
                                
                                var url = "index.php?r=reporte/parte/distribuciondediasyhoras&mes=" + mesjs + "&anio=" + aniojs + "&turno=" + turnojs;
                                document.getElementById("btnfiltrar").href = url;

        ',


        ]);?>

    </div> 

    <div class="form-group">
        <label for="btnfiltrar" style='color: #ffffff'>.</label><br />
        <?=
        Html::a('<span class="glyphicon glyphicon-filter" aria-hidden="true"></span>', '', ['id' => 'btnfiltrar', 'class' => 'btn btn-primary']); 
           
         ?>

    </div>
    
  <?= Html::endForm(); ?>



    
<?php 
setlocale(LC_TIME, 'spanish');
$fecha = DateTime::createFromFormat('!m', $mes);
$mestxt = ucfirst(strftime("%B", $fecha->getTimestamp()));

?>
<?php


$heatmap_options = [
    'scripts' => [
            'modules/heatmap',  // adds heatmap support
        ],

    'options' => [

            'title' => ['text' => 'Distribución de faltas por dia y hora de clase'],
            'chart' => [
                    'type' => 'heatmap'
            ],
            'credits' => [
                'enabled' => false,
            ],
            'xAxis' => [
                    'categories' => ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                    'title' => null,
                    'opposite' => true
            ],
            'yAxis' => [
                    'categories' => ['8°','7°','6°','5°','4°','3°','2°','1°','0°'],
                    'title' => 'Horas',
            ],

            'colorAxis' =>[
                    
                    //'minColor' => '#ffffff',
                    'maxColor' => '#92c7dd'

            ],

            'series' => [[
                    'name' => 'Faltas',
                    'borderWidth' => 1,
                    'data' => $data,
                    'dataLabels' => [
                            'enabled' => true,
                            'color' => '#000000'
                        ],

                    ]
            ]
    ]

];

echo Highcharts::widget($heatmap_options);

?>
</div>

