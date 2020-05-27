<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */

?>
<div id="contimpr">
	<div class="row">
		<div class="pull-right" style="margin-bottom: 10px;">
	        <button class="btn btn-default hidden-print" onclick="javascript:window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
	    </div>
	</div>
	<center>
		
		<div class="row">
			<div id="encabezado" style="width: 100px;">
            	<img src="assets/images/logo-encabezado.png" />
        	</div>
			<h4><?= $optnom ?></h4>
		</div>
	</center>
	<div class="row">
		<div class="clase-view" style="margin-top: 20px;">

		   
		   <?= $this->render('_alumnosxcomision', [
		        'dataProvider' => $dataProvider,
		        'searchModel' => $searchModel,
		        		                
		    ]) ?>

		</div>
	</div>
</div>