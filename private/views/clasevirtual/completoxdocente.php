<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */
date_default_timezone_set('America/Argentina/Buenos_Aires');
	
$semanainicio = Yii::$app->formatter->asDate($semana->inicio, 'dd/MM/yyyy');
$this->title = $docenteparam->apellido.', '.$docenteparam->nombre;
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="'.Yii::$app->request->referrer.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];


?>
<div class="horarioexamen-view">

    
    <div class="row">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
	 <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	   
	    <div  class="pull-right">
	        <?php 
	          	
	          	echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center>', Url::to(['print', 'agente' => $docenteparam->id, 'all' => false]), ['class' => 'btn btn-default'])
	        ?>
	    </div>
	</div>
</div>
    <center><h2>
 <?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode("Cronograma de Clases Virtuales") : '' ?>   
   
</h2></center>
    <div class="clearfix"></div>
    
    <div class='row' style="padding-bottom: 20px;">
    	
    	<div class="col-md-12"><center><h4>
    		<?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode('Agente: '.$this->title) : '' ?>
    	</h4></center></div>

	</div>
	

	<div class="clearfix"></div>
    <center><h3><?= "Semana del {$semanainicio}";
	?></h3></center>
    <div class='row'>
    	<div class="col-md-12">
		<div  class="pull-left">
			<h3>Turno mañana</h3>
		</div>	
		<div  class="pull-right">
			<?php 
				if($semn != null){
					$semn = $semn->id;
				echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxdocente&agente='.$docenteparam->id.'	&sem='.$semn.'"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';
			
				}else
				echo  '<a class = "btn bt	n-default" href="#"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';

					?>
	</div> 
	<div  class="pull-right">
		<?php 
		if($sema != null){
			$sema = $sema->id;
			echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxdocente&agente='.$docenteparam->id.'	&sem='.$sema.'"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';
		
		}else
		echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';

			
		
			?>
	</div>    
	
	<div class="clearfix"></div>
    		<?= GridView::widget([
		        'dataProvider' => $providerTm,
		        //'filterModel' => $searchModel,
		        'responsiveWrap' => false,
		        'summary' => false,
		        'columns' => $diasgridtm['columns'],
	    	]); ?>
    	</div>
    </div>
    <div class='row'>
    	<div class="col-md-12">
    		<h3>Turno tarde</h3>
    		<?= GridView::widget([
		        'dataProvider' => $providerTt,
		        //'filterModel' => $searchModel,
		        'responsiveWrap' => false,
		        'summary' => false,
		        'columns' => $diasgridtt['columns'],
	    	]); ?>
    	</div>
    		
    </div>	
	
    

</div>

