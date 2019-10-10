<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = $docenteparam->apellido.', '.$docenteparam->nombre;
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="'.Yii::$app->request->referrer.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];


?>
<div class="horariotrimestral-view">

    
    <div class="row">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
	 <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horariotrimestral/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="'.Yii::$app->request->referrer.'"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	
	          	echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center>', Url::to(['print', 'docente' => $docenteparam->id, 'all' => false]), ['class' => 'btn btn-default'])
	        ?>
	    </div>
	</div>
</div>
    <center><h2>
 <?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode('Citación de Examen Trimestral') : '' ?>   
   
</h2></center>
    <div class="clearfix"></div>
    
    <div class='row' style="padding-bottom: 20px;">
    	
    	<div class="col-md-12"><center><h4>
    		<?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode('Docente: '.$this->title) : '' ?>
    	</h4></center></div>

    </div>
    <div class='row' style="display: <?= $userhorario ?>;">
    	<div class="col-md-12">
    		Se comumica que los exámenes trimestrales correspondientes al <b><?= $anioxtrimestral->trimestral0->nombre ?></b> comenzarán el <b><?php date_default_timezone_set('America/Argentina/Buenos_Aires');
                echo Yii::$app->formatter->asDate($anioxtrimestral->inicio, 'dd/MM/yyyy'); ?></b> y teminarán el <b><?php date_default_timezone_set('America/Argentina/Buenos_Aires');
                echo Yii::$app->formatter->asDate($anioxtrimestral->fin, 'dd/MM/yyyy'); ?></b>. Deberá entregarlos con las correciones pertinentes con un plazo máximo de <b><u>TRES DÍAS</u></b> siguientes a su recepción. Luego se archivarán en preceptoría.<br/>
    		Saludamos a Usted muy atte.
    	</div>
    </div>
    <div class='row'>
    	<div class="col-md-12">
    		<h3>Turno mañana</h3>
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

