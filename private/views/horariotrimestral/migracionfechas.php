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