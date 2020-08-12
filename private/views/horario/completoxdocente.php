<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = $docenteparam['apellido'].', '.$docenteparam['nombre'];
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="'.Yii::$app->request->referrer.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];


?>
<div class="horario-view">

    <h1><?= (!$userhorario) ? Html::encode('Horario de Clases: '.$this->title) : '' ?>
    <div class="row" style="padding-bottom: 10px;">
<?php $dipl = ($userhorario) ? "none" : "block" ?>
	 <div style="display: <?=  $dipl  ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="'.Yii::$app->request->referrer.'"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/printxdocente&docente='.$docenteparam->id.'"><center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center></a>';;
	        ?>
	    </div>
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
		        'responsiveWrap' => false,
		        'summary' => false,
		        //'condensed' => ($pr==0) ? false : true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model) use($pr){
		                	if($pr == 0)
		                		return '<span class="badge">'.$model['0'].'</span>';
		                	return $model['0'];
		                }
		            ],
		            [
		                'label' => 'Lunes',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
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
						'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miércoles',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'contentOptions' => function ($model, $key, $index, $column) {
					        return ['style' => (strlen($model['4'])>2) ? 'background-color:#e1998e' : ''];
					    },
		                'attribute' => '4',
		                
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
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
		        'responsiveWrap' => false,
		        'summary' => false,
		        //'condensed' => ($pr==0) ? false : true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model) use($pr){
		                	if($pr == 0)
		                		return '<span class="badge">'.$model['0'].'</span>';
		                	return $model['0'];
		                }
		            ],
		            [
		                'label' => 'Lunes',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'attribute' => '2'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Martes',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miercoles',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'attribute' => '4'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
						'hAlign' => 'center',
						'format' => 'raw',
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

