<?php

use kartik\grid\GridView;
use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	$this->title = 'Historial académico de espacios curriculares';
?>

<h2><?=$this->title ?></h2>

	<div class="well"  style="margin-top:40px; width: 30%;">
	                
	                
	    <?php $form = ActiveForm::begin([
	        'id' => 'login-form',
	    ]); ?>

	        
	        
	        <?= $form->field($model, 'documento')->textInput()->label('Documento del Alumno') ?>
	       
	        <div class="form-group">
	            
	                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
	            
	        </div>

	    <?php ActiveForm::end(); ?>

	</div>

	
        <div id="alerta" class="alert invisible"></div>

	<div>
		<?php 

			if (isset($dataProvider)){

				//var_dump($matriculas);

				echo '<span><b><span style="font-size: 15pt;">'.
					$model->apellido.', '.$model->nombre.' </span></b>';
				echo GridView::widget([
					'dataProvider' => $dataProvider,
					'summary' => false,
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],
			
						[
							'label' => 'Año lectivo',
							'value' => function($model){
								return $model->comision0->espaciocurricular0->aniolectivo0->nombre;
							},

						],
						[
							'label' => 'Tipo',
							'value' => function($model){
								return $model->comision0->espaciocurricular0->actividad0->actividadtipo0->nombre;
							},

						],
						[
							'label' => 'Espacio curricular',
							'value' => function($model){
								return $model->comision0->espaciocurricular0->actividad0->nombre;
							},

						],
						[
							'label' => 'Curso',
							'value' => function($model){
								return $model->comision0->espaciocurricular0->curso.'°';
							},

						],
						[
							'label' => 'Condición',
							'value' => function($model){
								return $model->estadomatricula0->nombre;
							},

						],
					],
				]);

			}

			
			
			//echo Html::textArea('text', $texto, ['class' => 'form-control', 'rows' => '8', 'id'=> 'textoACopiar']);


		?>
		
		

	</div>