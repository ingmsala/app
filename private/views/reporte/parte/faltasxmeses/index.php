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

$this->title = 'Reporte - Evolucion Faltas por año';
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

     //$years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023']; 
    ?>

     <?php $years2=ArrayHelper::map($years,'nombre','nombre');  ?>


     <?= Html::beginForm(); ?>
     <div class="form-group col-xs-4 .col-sm-3">
     <?= Html::dropDownList('year', $selection=$anio, $years2, ['prompt' => '(Año)', 'id' => 'cmbyear', 'class' => 'form-control ',
        'onchange'=>'
                    var aniojs = document.getElementById("cmbyear").value;
                                                                
                                var url = "index.php?r=reporte/parte/faltasxmeses&anio=" + aniojs;
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
            
            [
                'label' => 'Meses',
                'attribute' => 'meses',
                'value' => function($model){
                        //return $model['meses'];
                        //$mesespok = [];
                        
                        $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',];
                        
                        return $meses[$model['meses']];
                        
                }
                
                
            ],
             [
                'label' => 'Cantidad de Faltas',
                'attribute' => 'faltas',
             ],

             [
                'label' => 'Dias de Clase',
                'attribute' => 'diasclase',
             ],

             [
                'header' => '% Ausentismo '.'<span data-toggle="tooltip" title="Se toma un aproximado de 395.5 horas cátedra diarias (Tomada de la suma ponderada por curso, horas semanales)" class="glyphicon glyphicon-info-sign"></span>',
                'value' => function($model){
                  return '~'.round(($model['faltas'] / ($model['diasclase'] * 395.5)) * 100,2).'%';
                }
             ],
           

            
        ],
    ]); ?>

<?php
if($anio!=0)
{


 $faltasarray =  ArrayHelper::getColumn($dataProvider->models, 'faltas');
 $diasclasearray =  ArrayHelper::getColumn($dataProvider->models, 'diasclase');

 $it = [];


for ($i = 0; $i < count($faltasarray); $i++) {
    $it[]=round(($faltasarray[$i] / ($diasclasearray[$i] * 395.5)) * 100,2);
    //$it[]= $faltasarray[$i] / $diasclasearray[$i];
}

 echo Highcharts::widget([

   'options' => [
      'chart' => [
            'type' => 'line',
        ],
      'title' => ['text' => $anio],
      'credits' => [
            'enabled' => false,
      ],
      'xAxis' => [
         'categories' => $mesespok
      ],
      'yAxis' => [
         'title' => ['text' => '%']
      ],
      'series' => [
         ['name' => ' % Ausentismo', 'data' => array_map('intval',$it)],
         //['name' => 'Turno Tarde', 'data' => [5, 7, 3]],

      ]
   ]
    ]);
}
    ?>

</div>