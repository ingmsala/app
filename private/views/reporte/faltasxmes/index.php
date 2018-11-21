<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\Highcharts;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Faltas por Mes';
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
    <?php $meses = [ 
        0 => 'Enero', 
        1 => 'Febrero',  
        2 => 'Marzo',
        3 => 'Abril',
        4 => 'Mayo',
        5 => 'Junio',
        6 => 'Julio',
        7 => 'Agosto',
        8 => 'Septiembre',
        9 => 'Octubre',
        10 => 'Noviembre',
        11=> 'Diciembre',

    ]; ?>

        <?php $years = [ 
        2018 => '2018',
        2019 => '2019',
        2020 => '2020',
        2021 => '2021', 
        ]; ?>

     <?php $form = ActiveForm::begin(); ?>
     <?= Html::dropDownList('mes', $selection= 2018, $years, ['prompt' => '(Año)', 'id' => 'year', 'class' => 'form-control', 'style' => 'width:15%',]); ?>
     <?= Html::dropDownList('mes', $selection= 10, $meses, ['prompt' => '(Mes)', 'id' => 'mes', 'class' => 'form-control', 'style' => 'width:15%',]); ?>

     <p>
        
        <?= Html::a('Filtrar', 'index.php?r=reporte/faltasxmes&mes=11', ['class' => 'btn btn-primary']) ?>
    </p>
    
    <?php ActiveForm::end(); ?>



    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                
                
            ],
             [
                'label' => 'Cantidad de Faltas',
                'attribute' => 'faltas',
             ],
           

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/faltasdocentes/view&id='),
                                'class' => 'modalaReporteHoras btn btn-link']);


                    },
                    
                ]

            ],
        ],
    ]); ?>

<?= Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Noviembre 2018'],
      'xAxis' => [
         'categories' => ArrayHelper::getColumn($dataProvider->models, 'fecha')
      ],
      'yAxis' => [
         'title' => ['text' => 'Faltas']
      ],
      'series' => [
         ['name' => ' Faltas', 'data' => array_map('intval',ArrayHelper::getColumn($dataProvider->models, 'faltas'))],
         //['name' => 'Turno Tarde', 'data' => [5, 7, 3]],

      ]
   ]
    ]);
    ?>

</div>