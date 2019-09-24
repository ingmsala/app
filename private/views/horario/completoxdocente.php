<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = $docenteparam->apellido.', '.$docenteparam->nombre;


?>
<div class="horario-view">

    <h1><?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode('Horario de Clases: '.$this->title) : '' ?>
    <div style="display: none;">
	     <div class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
	        <?php 
	          	echo  '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	</div>
    
    
   
</h1>
    <div class="clearfix"></div>
    <div class='row'>
    	<div class="col-md-6">
    		<h3>Turno mañana</h3>
    		<?= GridView::widget([
		        'dataProvider' => $providerTm,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model){
		                	return '<span class="badge">'.$model['0'].'</span>';
		                }
		            ],
		            [
		                'label' => 'Lunes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'contentOptions' => function ($model, $key, $index, $column) {
					        return ['style' => 'background-color:' 
					            . (strlen($model['2'])>2) ? 'red' : 'black'];
					    },
						'attribute' => '2'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Martes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miercoles',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'contentOptions' => function ($model, $key, $index, $column) {
					        return ['style' => (strlen($model['4'])>2) ? 'background-color:#e1998e' : ''];
					    },
		                'attribute' => '4',
		                
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '6'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            

		            
		        ],
	    	]); ?>
    	</div>

    	<div class="col-md-6">
    		<h3>Turno tarde</h3>
    		<?= GridView::widget([
		        'dataProvider' => $providerTt,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model){
		                	return '<span class="badge">'.$model['0'].'</span>';
		                }
		            ],
		            [
		                'label' => 'Lunes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '2'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Martes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miercoles',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '4'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'attribute' => '6'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            

		            
		        ],
	    	]); ?>
    	</div>
    		
    </div>	
	
    

</div>

