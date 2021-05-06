<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asistencia preceptores';

?>

<div class="revista-index">

   
    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'responsiveWrap' => false,
				'condensed' => true,
				'options' => ['style' => 'font-size:0.7em;'],
				'panel' => [
					'type' => GridView::TYPE_DEFAULT,
					'heading' => Html::encode($this->title),
					//'beforeOptions' => ['class'=>'kv-panel-before'],
				],
				'summary' => false,
		
				'exportConfig' => [
					GridView::EXCEL => [
						'label' => 'Excel',
						'filename' =>Html::encode($this->title),
						
						//'alertMsg' => false,
					],
					
		
				],
		
				'toolbar'=>[
					['content' => 
						''
		
					],
					'{export}',
					
				],
		        'columns' => $datacolumn['columns']
		        
	    	]); ?>

</div>