<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;
use kartik\detail\DetailView;
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
	
	 
<?php

if(Yii::$app->params['devicedetect']['isMobile']){
	date_default_timezone_set('America/Argentina/Buenos_Aires');
		
	$models = $provider->getModels();
	$i = 0;
	foreach ($models as $model) {

		echo '<div class="col-md-4">';
                echo DetailView::widget([
                    'model'=>$model,
                    'condensed'=>true,
                    'hover'=>true,
                    'mode'=>DetailView::MODE_VIEW,
                    'enableEditMode' => false,
                    'panel'=>[
                        'heading'=>$model['0'],
                        'headingOptions' => [
                            'template' => '',
                        ],
                        'type'=>DetailView::TYPE_DEFAULT,
                    ],
                    'attributes'=>[
                        
                        [
							'label' => 'Domingo',
							'vAlign' => 'middle',
							'hAlign' => 'center',
							'format' => 'raw',
							'attribute' => '1',
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
							/*'value' => function($model){
								return var_dump($model);
							}*/
						],
						[
							'label' => 'Lunes',
							'vAlign' => 'middle',
							'hAlign' => 'center',
							'format' => 'raw',
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
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
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
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
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
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
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
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
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
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
							'valueColOptions' => ['style'=>'vertical-align: middle; text-align:center;'],
							'attribute' => '7'
							/*'value' => function($model){
								return var_dump($model);
							}*/
						],
                        
                    ]
                ]);
				echo '</div>';
				
			}
			echo '<div class="clearfix"></div>';

	
}else{


echo GridView::widget([
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
		                'label' => 'Cargo o actividad',
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
			]);
			
			}
	
	?>
		<?php
			if($lic==1){
				echo '<em><span style="color:red">*</span> En los cargos o actividad declarados en Licencia no se deben especificar horarios</em>';
			}


		?>
		
		<?php $form = ActiveForm::begin(); ?>	
		<div class="form-group">
			<div class="pull-right"><?= Html::submitButton('Siguiente >', ['class' => 'btn btn-primary']) ?></div>
			<div class="pull-right">&nbsp;</div>
			<div class="pull-right"><?= Html::a('< Anterior', Url::to('index.php?r=declaracionjurada/percepciones'), $options = ['class' => 'btn btn-primary']); ?></div>
        </div>
		<?php ActiveForm::end(); ?>
</div>