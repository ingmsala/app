<?php 
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	$this->title = 'Interfaz Yacaré - Analíticos';
?>

<h2><?=$this->title ?></h2>

	<div class="well"  style="margin-top:40px; width: 30%;">
	                
	                
	    <?php $form = ActiveForm::begin([
	        'id' => 'login-form',
	    ]); ?>

	        
	        
	        <?= $form->field($model, 'dni')->textInput()->label('Documento del Alumno') ?>
	       
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
				echo '<a href="#" id="btnCopiar" class="btn btn-default"><span class="glyphicon glyphicon-copy"></a></span>';
			}

			if (isset($lista)){
				
				$texto = 'El alumno/a ha aprobado los siguientes espacios optativos curriculares:';
				$texto .= $lista;
			}else{
				$texto = '';
			}
			
			//echo Html::textArea('text', $texto, ['class' => 'form-control', 'rows' => '8', 'id'=> 'textoACopiar']);


		?>
		
		<blockquote>
			<div id="textoACopiar" class="">
				<?= strip_tags (htmlspecialchars(trim($texto)), ENT_QUOTES); ?>
	        </div>
		</blockquote>

	</div>