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

$this->title = 'Reporte - Comparación por Turno en un año';
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
    <?php 

     $years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023']; ?>

     <?= Html::beginForm(); ?>
     <div class="form-group col-xs-4 .col-sm-3">
     <?= Html::dropDownList('year', $selection=$anio, $years, ['prompt' => '(Año)', 'id' => 'cmbyear', 'class' => 'form-control ',
        'onchange'=>'
                    var aniojs = document.getElementById("cmbyear").value;
                                                                
                                var url = "index.php?r=reporte/parte/faltasxanioxturnototal&anio=" + aniojs;
                                document.getElementById("btnfiltrar").href = url;

        ',


        ]);?>

    </div> 
    
    <div class="form-group">
        
        <?php
            
         echo Html::a('<span class="glyphicon glyphicon-filter" aria-hidden="true"></span>', '', ['id' => 'btnfiltrar', 'class' => 'btn btn-primary']); 
           
         ?>

    </div>
    
  <?= Html::endForm(); ?>



    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            
            'anio',
             [
                'label' => 'Mañana',
                'attribute' => 'manana',
             ],

             [
                'label' => 'Tarde',
                'attribute' => 'tarde',
             ],
           

            
        ],
    ]); ?>

<?php
if($anio!=0)
{
   echo Highcharts::widget([
        'options' => [
            'title' => ['text' => $anio],
            'plotOptions' => [
                'pie' => [
                    'cursor' => 'pointer',
                ],
            ],
            'credits' => [
                'enabled' => false,
            ],
            'series' => [
                [ // new opening bracket
                    'type' => 'pie',
                    'name' => 'Faltas',
                    'data' => [
                        ['Mañana', intval($dataProvider->models[0]['manana'])],
                        ['Tarde', intval($dataProvider->models[0]['tarde'])],
                        
                    ],
                ] // new closing bracket
            ],
        ],
    ]);
}
?>

</div>