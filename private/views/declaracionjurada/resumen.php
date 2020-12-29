<?php

use app\config\Globales;
use app\models\Horariodj;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Declaración Jurada';

?>

<div class="horarioxcurso-view">
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>Motivo de Rechazo</h2>",
            'id' => 'modalrechazar',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
<h1><?= Html::encode('Declaración Jurada') ?></h1>
    <h4 class="text-muted">De los cargos y actividades  que desempeña el causante</h4>

    <table class="kv-grid-table table table-bordered">
    
        <tr>
            <td rowspan="3" style="background-color:#eaeaea;width:1em;">1</td>
            <td><b><?=
                $agente->tipodocumento0->nombre.': '
            ?></b><?= $agente->documento?></td>
            <td><b>CUIL N°: </b><?= $agente->cuil?></td>
            <td><b>LEGAJO N°: </b><?= $agente->legajo?></td>
        </tr>

        <tr>
            <td>Cédula de identidad N°:</td>
            <td colspan ="2"><b>Expedida por: Policía</b></td>
            
        </tr>

        <tr>
            <td>En caso de no poseer estos documentos especifique su documentación </td>
            <td colspan ="2"><b>Fecha de nacimiento: </b><?php 
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            echo Yii::$app->formatter->asDate($agente->fechanac, 'dd/MM/yyyy');
            ?></td>
            
        </tr>

    </table>
    
    <table class="kv-grid-table table table-bordered">
    
        <tr>
            <td rowspan="1" style="background-color:#eaeaea;width:1em;">2</td>
            
            <td><b>APELLIDOS: </b><?= $agente->apellido?></td>
            <td><b>NOMBRES: </b><?= $agente->nombre?></td>
        </tr>

        

    </table>
    
    <table class="kv-grid-table table table-bordered">
    
        <tr>
            <td rowspan="2" style="background-color:#eaeaea;width:1em;">3</td>
            
            <td colspan="2"><b>DOMICILIO: </b><?= $agente->domicilio?></td>
            <td colspan="2"><b>LOCALIDAD: </b><?= $agente->localidad0->nombre?></td>
            <td><b>PCIA: </b><?= 'Córdoba' ?></td>
        </tr>

        <tr>
            <td colspan="2"><b>TELÉFONO: </b><?= $agente->telefono?></td>
            <td colspan="3"><b>CORREO ELECTRÓNICO: </b><?= $agente->mail ?></td>
            
        </tr>   

    </table>
    <div><b>DATOS RELACIONADOS CON LAS FUNCIONES, CARGOS Y OCUPACIONES</b></div> 
    <?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
                'summary' => false,
                
		        'responsiveWrap' => false,
				//'condensed' => true,
				'striped' => false,

		        'columns' => [
		            
		            [
		                'label' => '',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                
					],
					[
		                'label' => 'Entidad',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '5',
		                
					],
					[
		                'header' =>  'Dependencia',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '6'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
                    [
		                'header' =>  'Repartición, Establecimiento, <br />Institución u Oficina',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '1'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            [
		                'header' => 'Cargo o <br />Destino',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '2'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'header' => 'Total de <br />Horas',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
					],
					
					[
		                'header' => 'Licencia',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '7'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'header' => 'Conformidad o empleo de la 
                        Repartición,<br /> Establecimiento,<br />
                        Institución u Oficina',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '4'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
   
		        ],
            ]); ?>
    <div><b>EN TAREAS O ACTIVIDADES NO OFICIALES</b></div>    
       
    <table class="kv-grid-table table table-bordered">
    
        <tr>
            <td rowspan="3" style="background-color:#eaeaea;width:1em;">9</td>
            <td colspan="2"><b>Empleador: </b><?= ($actividadnooficial != null) ? $actividadnooficial->empleador : '-' ?></td>
            <td colspan="2"><b>Lugar donde presta servicio: </b><?= ($actividadnooficial != null) ? $actividadnooficial->lugar : '-' ?></td>
        </tr>

        <tr>
            <td colspan="2"><b>Sueldo o Retribución: </b><?= ($actividadnooficial != null) ? '$ '.$actividadnooficial->sueldo : '-' ?></td>
            <td colspan="2"><b>Funciones que desempeña: </b><?= ($actividadnooficial != null) ? $actividadnooficial->funcion : '-' ?></td>
        </tr> 
        <tr>
			<td colspan="2"><b>Horario que cumple: </b><?php
			if($actividadnooficial != null){
			date_default_timezone_set('America/Argentina/Buenos_Aires');
                    
			$hj =Horariodj::find()->where(['actividadnooficial' => $actividadnooficial->id])->one();
			echo Yii::$app->formatter->asDate($hj->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($hj->fin, 'HH:mm');
			}else{
				echo '-';
			}
			?></td>
			<td colspan="2"><b>Ingreso: </b><?php 
									if($actividadnooficial != null){
										date_default_timezone_set('America/Argentina/Buenos_Aires');
                   						echo Yii::$app->formatter->asDate($actividadnooficial->ingreso, 'dd/MM/yyyy');
										
									}else{
										echo '-';
									} ?></td>
        </tr>   

    </table>
    
    <div><b>PERCEPCION DE PASIVIDADES (Jubilaciones, Pensiones, Retiros, etc.)</b></div>
    
    <table class="kv-grid-table table table-bordered">
    
        <tr>
            <td rowspan="3" style="background-color:#eaeaea;width:1em;">10</td>
            <td><b>Régimen: </b><?= ($pasividaddj != null) ? $pasividaddj->regimen : '-' ?></td>
            <td><b>Causa: </b><?= ($pasividaddj != null) ? $pasividaddj->causa : '-' ?></td>
            <td><b>Institución o caja que lo abona: </b><?= ($pasividaddj != null) ? $pasividaddj->caja : '-' ?></td>
        </tr>

        <tr>
            <td colspan="3"><b>Desde que fecha: </b><?php
                if($pasividaddj != null){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    echo Yii::$app->formatter->asDate($pasividaddj->fecha, 'dd/MM/yyyy');
                }else
                        echo '-'; ?></td>
            
        </tr> 
        <tr>
			<td colspan="3"><b>Determinar si percibe el beneficio o si ha sido suspendido a pedido del titular: </b><?php
			if($pasividaddj != null){
				if($pasividaddj->percibe == 1)
					echo 'Percibo';
				else
					echo 'Suspendido';
			}else{
				echo '-';
			}
			
				
			?></td>
            
        </tr>   

    </table>

	<formfeed>
    
    <h5><b>CUADRO DEMOSTRATIVO DEL CUMPLIMIENTO DE LOS HORARIOS PARA LOS CARGOS Y ACTIVIDADES</b></h5>
    <?= GridView::widget([
		        'dataProvider' => $provider2,
		        //'filterModel' => $searchModel,
                'summary' => false,
                
		        'responsiveWrap' => false,
				//'condensed' => true,
				'striped' => false,

		        'columns' => [
		            [
		                'label' => '',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '-1',
		                'value' => function($model){
		                	return $model['-1'];
		                	
		                }
                    ],
		            [
		                'header' => 'DENOMINACIÓN DEL CARGO Y <br />
                                                CERTIFICACIÓN DE HORARIO',
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
			
			<div class="leyendas">

				LUGAR Y FECHA: Córdoba, <?php
					date_default_timezone_set('America/Argentina/Buenos_Aires');
					$meses = [ '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',];
					setlocale(LC_TIME, "es_ES");
					echo Yii::$app->formatter->asDate(date('Y-m-d'), 'dd').' de '.$meses[date('m')].' de '.strftime("%Y");
				?>
				
			</div>
            
            <div class="well well-lg">
			Declaro bajo juramento que todos los datos consignados son veraces y exactos, de acuerdo  a mi leal saber y entender. Asimisimo, me notifico que cualquier falsedad, ocultamiento u omisión dará motivo a las más severas sanciones disciplinarias, como así también que estoy obligado a denunciar dentro de las cuarenta y ocho horas las modificaciones  que se produzcan en el futuro.-
            <?php
				if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA])){
			
				echo '<div class="form-group">';
                	
				if($declaracionjurada->estadodeclaracion == 2){
					echo '<div class="pull-right">'.Html::a('<span class="btn btn-success">Aceptar declaración jurada</span>', '?r=declaracionjurada/cambiarestado', 
							['data' => [
							
							'confirm' => '¿Desea <b>aceptar</b> la declaración jurada?',
							'method' => 'post',
							'params' => [
											'es' => 3,
											'dj' => $declaracionjurada->id,
										],
							]
							]).'</div>';
					echo '<div class="pull-right">&nbsp;</div>';
					echo '<div class="pull-right">'.Html::button('Rechazar declaración jurada', ['value' => Url::to('index.php?r=mensajedj/create&dj='.$declaracionjurada->id), 'class' => 'btn btn-danger amodalrechazar']).'</div>';
                        
					
				}
				echo '<div class="pull-right">&nbsp;</div>';
				echo ' <div class="pull-right">'.Html::a('< Anterior', Url::to(Yii::$app->request->referrer), $options = ['class' => 'btn btn-primary']).'</div>';
            	
				echo '</div>';	
				
				}else{
			?>
            <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
            
            <div class="form-group">
                <div class="pull-right">
                    <?= ($declaracionjurada->estadodeclaracion == 1 || $declaracionjurada->estadodeclaracion == 4) ? Html::submitButton('Aceptar y enviar', ['class' => 'btn btn-success']) : Html::a('< Volver', Url::to('index.php?r=declaracionjurada'), $options = ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="pull-right">&nbsp;</div>
                <div class="pull-right"><?= ($declaracionjurada->estadodeclaracion == 1 || $declaracionjurada->estadodeclaracion == 4) ? Html::a('< Anterior', Url::to('index.php?r=declaracionjurada/horarios'), $options = ['class' => 'btn btn-primary']) : '' ?></div>
            </div>

			<?php ActiveForm::end(); ?>
			<?php
				}
			?>
			
	</div>
			<div class="leyendas">
			<div class="leyenda-center">.........................................................</div>
								<div class="leyenda-center">Firma del Declarante</div>
			
			</div>
			<div class="leyendas">

				LUGAR Y FECHA: Córdoba, <br />
				<div class="well well-lg">Certifico la exactitud de las informaciones contenidas en los cuadros 1, 2, 3, y la autenticidad de la firma que antecede. Manifiesto que no tengo
conocimiento que en la presente el declarante haya incurrido en ninguna falsedad, ocultamiento u omisión.-</div>
				
			</div>
			<div class="leyendas">
			<div class="leyenda-center">.........................................................</div>
								<div class="leyenda-center">Firma del Jefe</div>
								
			</div>
			<div class="leyendas">

				LUGAR Y FECHA: Córdoba, <br />
				<div class="well well-lg">Conste que he recibido el original y el duplicado de la presente declaración jurada, constatando que los tres ejemplares son similares y contienen
iguales informaciones y certificaciones.-</div>
				
			</div>
			<div class="leyendas">
			<div class="leyenda-center">.........................................................</div>
								<div class="leyenda-center">Firma del Jefe</div>
								
			</div>
	
</div>