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
            	'label' => 'Total Faltas',
            	'attribute' => 'detallepartes.falta',
            	'format' => 'raw',
            	'value' =>  function($model){


            		//echo var_dump($model->nombramientos);
            		$cantHorasFalta = [];
            		
            		foreach($model->detallepartes as $df){
                        if($df->falta <= 2){
                            $cantHorasFalta[] = 40;
                        }elseif($df->falta == 3){
                             $cantHorasFalta[] = $df->retiro + $df->llego;
                        }elseif($df->falta == 4){
                             $cantHorasFalta[] = -40;
                        }

                    }
                        
                    

                    

                    $total = array_sum($cantHorasFalta);
                    $horas = $total/40;
                    $minutos = ($horas-intval($horas))*40;
                    return intval($horas).'h:'.$minutos;
                
                }
            		//return $model->nombramientos->horas;
            	
            ],
           

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/parte/faltasdocentes/view&id='.$model->id),
                                'class' => 'modalaReporteHoras btn btn-link']) : '';


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>