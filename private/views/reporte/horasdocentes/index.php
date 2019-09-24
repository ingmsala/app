<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Horas por Docentes';
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

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            
            'legajo',
            'apellido',
            'nombre',
            [
            	'label' => 'Total Horas',
            	'attribute' => 'nombramientos.horas',
            	'format' => 'raw',
            	'value' =>  function($model){


            		//echo var_dump($model->nombramientos);
            		$nombramHoras = [];
            		$hCatedraHoras = [];
            		foreach($model->nombramientos as $nombramiento){
                        if($nombramiento->revista <> 2)
                            $nombramHoras[] = $nombramiento->horas;
                        
                    }

                    foreach($model->detallecatedras as $detalle){
                        if($detalle->revista <> 2 && $detalle->activo == 1 && $detalle->revista <> 6)
                    	   $hCatedraHoras [] = $detalle->hora;
                    	              	    
                    }

                    $sumaHCatedra = array_sum($hCatedraHoras);
                    $sumaNombramientos = array_sum($nombramHoras);
                    return ($sumaNombramientos + $sumaHCatedra);
                
                }    
            		//return $model->nombramientos->horas;
            	
            ],
            [
                'label' => 'Género',
                'attribute' => 'genero',
                'value' => function($model){
                //echo var_dump($model);
                //echo var_dump($model->catedras);
                //echo var_dump($model->nombramientos);
                   return $model->genero0->nombre;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/horasdocentes/view&id='.$model->id),
                                'class' => 'modalaReporteHoras btn btn-link']) : '';


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>