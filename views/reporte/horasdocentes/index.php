<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Docente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'id',
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

                        $nombramHoras[] = $nombramiento->horas;
                        
                    }

                    foreach($model->detallecatedras as $detalle){

                    	$hCatedraHoras [] = $detalle->catedra0->actividad0->cantHoras;
                    	              	    
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>