<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\config\Globales;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = 'Migración de fechas';

?>
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">Migración de Horarios desde el <?= $axt->trimestral0->nombre.' de '.$axt->aniolectivo0->nombre ?></div>
	<div class="panel-body">
			
			<?php $form; ?>
			<?php /*echo GridView::widget([
					        'dataProvider' => $providerTm,
					        //'filterModel' => $searchModel,
					        'responsiveWrap' => false,
					        'summary' => false,
					        'columns' => $diasgridtm['columns'],
				    	]); */?>


	    	<?= $echodiv ?>

	    	<div class="form-group">
		        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id' => 'btnausentes']) ?>
		    </div>

   			 <?php ActiveForm::end(); ?>
	</div>

	
</div>