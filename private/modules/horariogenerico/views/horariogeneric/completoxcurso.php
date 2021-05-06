<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;
use app\models\Semana;
use app\modules\horariogenerico\models\Horariogeneric;

$this->params['sidebar'] = [
    'visible' => false,
    
];

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

if($vista == 'docentes')
	$txt = 'Docentes';
else
	$txt = 'Materias';
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	
	$semanainicio = Yii::$app->formatter->asDate($semana->inicio, 'dd/MM/yyyy');
$this->title = "Clases de la semana: {$semanainicio} - ".$paramdivision->nombre;
/*$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="index.php?r=horarioexamen/menuxdivision&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];

if($vista == 'docentes')
	        	$this->params['itemnav2'] = ['label' => '<a class="menuHorarios" href="index.php?r=horarioexamen/completoxcurso&division='.$paramdivision->id.'&vista=materias&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>'];
	        else
	        	$this->params['itemnav2'] = ['label' =>   '<a class="menuHorarios" href="index.php?r=horarioexamen/completoxcurso&division='.$paramdivision->id.'&vista=docentes&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>'];
*/?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
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
<div class="horarioxcurso-view">

	<?php  
 $js=<<< JS
     $('[rel="tooltip"]').tooltip();
JS;

?>

	
<?php
if($prt != 1){
?>
    <h2><?= Html::encode($this->title);?>
	</h2>
    <?php $userhorario = $horariopremitido ? "none" : "block" ?>
    <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/panelprincipal&col='.$sem.'"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div class="pull-right">
	        <?php 
	        if($vista == 'docentes')
	        	echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/completoxcurso&division='.$paramdivision->id.'&vista=materias&sem='.$sem.'"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
	        else
	        	echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/completoxcurso&division='.$paramdivision->id.'&vista=docentes&sem='.$sem.'"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/menuxdivision"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	
	          	echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center>', Url::to(['printcursos', 'division' => $paramdivision->id, 'all' => false, 'sem' => $sem]), ['class' => 'btn btn-default'])
	        ?>
	    </div>
    </div>
    
<div  class="pull-left">
		<?php 
		if($sema != null){
			$sema = $sema->id;
			echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/'.$origen.'&division='.$paramdivision->id.'&vista=docentes&sem='.$sema.'"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';
		
		}else
		echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';

			
		
			?>
</div>    
<div  class="pull-left">
		<?php 
			if($semn != null){
				$semn = $semn->id;
			echo  '<a class = "btn btn-default" href="index.php?r=horariogenerico/horariogeneric/'.$origen.'&division='.$paramdivision->id.'&vista=docentes&sem='.$semn.'"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';
		
			}else
			echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';

				?>
</div> 
   

    <div class="clearfix" style="padding-bottom: 10px;"></div>	

	<?php
	}else{
		echo '<h3>'.Html::encode($this->title).'</h3>';
	}
	?>
	<?php
		try {
			echo '<h3><div style="text-align:center;margin: auto;width: 50%;">Semana '.$semana->tiposemana0->nombre.'</div></h3>';
		} catch (\Throwable $th) {
			//throw $th;
		}
	
	?>
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
				'striped' => false,
		        'responsiveWrap' => false,
		        'columns' => $diasgrid['columns']
		        /*'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model){
		                	return '<span class="badge">'.$model['0'].'</span>';
		                }
		            ],
		            
		            $diasgrid['columns'][0]
		            
		            
		        ],*/
	    	]); ?>

	<?php
		/*if($prt != 1){
				echo '<center>';
				echo Html::a('Ver horarios de Ed. Física', '#collapse', ['data-toggle'=>"collapse", 'class' => 'btn btn-success btn-lg']);
				echo '</center>';
				echo '<br/><br/>';
				
					
				$d ='<div id="collapse" class="panel-collapse collapse">
						<iframe src="https://drive.google.com/file/d/1cFHp5OmJlH4UTiuQKzody2yZRXbBpA44/preview" width="100%" height="780"></iframe>
					</div>';
				
				
				echo $d;
				//echo '<iframe src="https://drive.google.com/file/d/1cFHp5OmJlH4UTiuQKzody2yZRXbBpA44/preview" width="640" height="480"></iframe>';
		}*/
		echo $horarioedfisica;
	?>
	  <?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        //'filterModel' => $searchModel,
		        'condensed' =>true,
		        'striped' =>true,
		        'responsiveWrap' => false,
		        'summary' => false,
		        /*'rowOptions' => function($model) use($listdc) {
					
		        	try {
            			$cant = array_count_values($listdc)[$model->id];
            			if($cant > 0)
            				return ['class' => 'success'];
            		} catch (Exception $e) {
            			return ['class' => 'danger'];
            		}

		            
		        },*/
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],

		            [
		            	'class' => 'kartik\grid\BooleanColumn',
		            	'label' => '',
		            	'visible' => ($columnpremitido && $prt==0) ? true : false,
		            	'value' => function($model) use($listdc) {
		            		//return var_dump(array_count_values($listdc));
		            		try {
		            			if(array_count_values($listdc)[$model->id]==0)
		            				return false;
		            			return true;
		            		} catch (Exception $e) {
		            			return false;
		            		}
		            		
		            	}

		            ],
		            
		            [
		            	'label' => 'Materia',
		            	'value' => function($model){
		            		return $model->catedra0->actividad0->nombre;
		            	}

		            ],

		            [
		            	'label' => 'Docente',
		            	'format' => 'raw',
		            	'value' => function($model) use ($sem, $prt, $regenciapermitido) {
							if($regenciapermitido){
								if($prt == 0)
									return Html::a($model->agente0->apellido.', '.$model->agente0->nombre, Url::to(['completoxdocente', 'agente' => $model->agente, 'col' => 0]));
								else
									return $model->agente0->apellido.', '.$model->agente0->nombre;
							}
							return $model->agente0->apellido.', '.$model->agente0->nombre;
		            	}

		            ],
		            [
		            	'label' => 'Total de clases',
		            	'format' => 'raw',
						'visible' => $regenciapermitido,
		            	'value' => function($model) use ($sem, $prt) {
							$salida = '';
							$semana = Semana::findOne($sem);
		            		$bur1 = Horariogeneric::find()
								->joinWith(['catedra0', 'semana0'])
								->where(['horariogeneric.aniolectivo' => $semana->aniolectivo])
								->andWhere(['catedra.id' => $model->catedra])
								->andWhere(['semana.tiposemana' => $semana->tiposemana])
								->andWhere(['burbuja' => 1])
								->count();
							$salida .= '<span class="label label-red">'.$bur1.'</span> ';
		            		$bur2 = Horariogeneric::find()
								->joinWith(['catedra0', 'semana0'])
								->where(['horariogeneric.aniolectivo' => $semana->aniolectivo])
								->andWhere(['catedra.id' => $model->catedra])
								->andWhere(['semana.tiposemana' => $semana->tiposemana])
								->andWhere(['burbuja' => 2])
								->count();
							$salida .= '<span class="label label-blue">'.$bur2.'</span> ';
		            		$bur3 = Horariogeneric::find()
								->joinWith(['catedra0', 'semana0'])
								->where(['horariogeneric.aniolectivo' => $semana->aniolectivo])
								->andWhere(['catedra.id' => $model->catedra])
								->andWhere(['semana.tiposemana' => $semana->tiposemana])
								->andWhere(['burbuja' => 3])
								->count();
							$salida .= '<span class="label label-yellow">'.$bur3.'</span>';
							return $salida;
		            	}

		            ],

		            

		            
		        

				[
	                'class' => 'kartik\grid\ActionColumn',

	                'template' => '{viewdetcat} {dj}',
	                'visible' => $regenciapermitido,
	                
	                'buttons' => [
	                    'viewdetcat' => function($url, $model, $key)use ($sem){
	                        return Html::a(
	                            '<span class="glyphicon glyphicon-eye-open"></span>',
	                            '?r=detallecatedra/updatehorario&or=hg&id='.$model['id'].'&sem='.$sem);
						},
						
						'dj' => function($url, $model, $key){
	                        return Html::button('<span class="glyphicon glyphicon-modal-window"></span>',
                            ['value' => Url::to('index.php?r=horario/declaracionhorario&dni='.$model->agente0->documento),
                                'class' => 'modala btn btn-link', 'id'=>'modala']);
	                            
	                    },

	                    'updatedetcat' => function($url, $model, $key){
                        
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to('index.php?r=detallecatedra/updatehorario&id='.$model['id']),
                                'class' => 'modala btn btn-link', 'id'=>'modala']);


                    },
	                    
	                    
	                ]
				],
			],
	    	]); ?>
    

</div>

<?php $this->registerJs($js, yii\web\View::POS_READY); ?>

