<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;
use kartik\form\ActiveForm;

$this->title = 'Declaración jurada';
?>

<h1><?= Html::encode('Declaración jurada') ?></h1>
    
<div class="horarios-dj">

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalpasividad',
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
                'hover' => true,
		        'responsiveWrap' => false,
				'condensed' => true,
				'panel' => [
					'type' => GridView::TYPE_DEFAULT,
					'heading' => Html::encode('Cuadro demostrativo del cumplimiento de los horarios para los cargos y actividades'),
					'before' => false,
					'footer' => false,
					'after' => false,
				],
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Cargo',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model){
		                	return $model['0'];
		                	
		                }
                    ],
                    [
		                'label' => 'Domingo',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '1'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
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
		                'label' => 'Miércoles',
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
                    
                    [
		                'label' => 'Sábado',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '7'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            

		            
		        ],
			]); ?>
		<?php $form = ActiveForm::begin(); ?>	
		<div class="form-group">
			<div class="pull-right"><?= Html::submitButton('Siguiente >', ['class' => 'btn btn-primary']) ?></div>
			<div class="pull-right">&nbsp;</div>
			<div class="pull-right"><?= Html::a('< Anterior', Url::to('index.php?r=declaracionjurada/percepciones'), $options = ['class' => 'btn btn-primary']); ?></div>
        </div>
		<?php ActiveForm::end(); ?>
</div>