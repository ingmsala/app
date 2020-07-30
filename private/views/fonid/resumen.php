<?php

use app\config\Globales;
use app\models\Horariodj;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'FONID';

?>

<div class="horarioxcurso-view">
<div class="encab">
	<h2><?= Html::encode('MINISTERIO DE EDUCACIÓN') ?></h2>
    <h2>FONID <?= Yii::$app->formatter->asDate($model->fecha, 'yyyy'); ?></h2>
</div>
        
    <table class="kv-grid-table table">
    
        <tr>
            <td><b>NOMBRES Y APELLIDOS: </b><?= $persona->nombre.' '.$persona->apellido?></td>
		</tr>
        <tr>
            <td><b>N° DE CUIL: </b><?= $persona->cuil?></td>
		</tr>
		<tr>
            <td><b>N° DE LEGAJO: </b><?= $persona->legajo?></td>
        </tr>

        

    </table>
    
    <table class="kv-grid-table table table-bordered">
    
        <tr class="kv-align-center">
			
			<td class="kv-align-center">UNIVERSIDAD NACIONAL DE CÓRDOBA <br /><br />
			COLEGIO NACIONAL DE MONSERRAT</td>
            
        </tr>   

	</table>
	
    <div class="kv-align-center">OTROS ESTABLECIMIENTOS EN DONDE SE DESEMPEÑA CON CARÁCTER DE DOCENTE</div> 
    <h1>AÑO <?=
		Yii::$app->formatter->asDate($model->fecha, 'yyyy');
	?></h1> 
	
	<?php

		$tot = $dataProvider->getTotalCount();
		$vacias = (5 - $tot);

		if($tot == 0){
			$tabla = '';

			for ($i=0; $i < $vacias; $i++) { 
						
					
					$tabla .= "<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					</tr>";
				}
				

			$tabla .= '';
		}else{
			$tabla = false;
		}

		

		echo GridView::widget([
			'dataProvider' => $dataProvider,

			'summary' => false,
			
			'emptyText' => $tabla,

			'afterRow'=>function ($model, $key, $index, $grid) use ($vacias, $tot){
				if($index===($tot-1)){
					$t='';
						for ($i=0; $i < $vacias; $i++) { 
							
						
						$t .= "<tr>
						
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						</tr>";
					}
					return $t;
				}
			
			},
			
			'columns' => [
				//['class' => 'yii\grid\SerialColumn'],
	
				
				[
					'label' => 'Jurisdicción',
					'value' => function($model){
						return $model->jurisdiccion;
					}
				],
				[
					'header' => 'Denominación<br/> del <br/> Establecimiento',
					'value' => function($model){
						return $model->denominacion;
					}
				],
				[
					'label' => 'Nombre',
					'value' => function($model){
						return $model->nombre;
					}
				],
				[
					'label' => 'Cargo',
					'value' => function($model){
						return $model->cargo;
					}
				],
				[
					'header' => 'Cantidad de <br/> Horas',
					'value' => function($model){
						return $model->horas;
					}
				],
				
				[
					'header' => 'Secundarias o <br/> Terciarias',
					'value' => function($model){
						if($model->tipo == 1){
							return "Secundarias";
						}
						return "Terciarias";
					}
				],
				[
					'label' => 'Observaciones',
					'value' => function($model){
						return $model->observaciones;
					}
				],
	
				
			],
		]);
	?>
	
    <div>DECLARO BAJO JURAMENTO QUE LOS DATOS CONSIGNADOS EN LA PRESENTE SON LOS CORRECTOS</div><br /><br />    
	<div>FECHA: <?php
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	echo Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
	?></div>    
       
    
			
			
</div>