<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */

?>
<div id="contimpr">
	
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