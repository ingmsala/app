<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

if($vista == 'docentes')
	$txt = 'Docentes';
else
	$txt = 'Materias';
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	
	$semanainicio = Yii::$app->formatter->asDate($semana->inicio, 'dd/MM/yyyy');
$this->title = "Clases virtuales de la semana: {$semanainicio} - ".$paramdivision->nombre;
/*$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="index.php?r=horarioexamen/menuxdivision&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];

if($vista == 'docentes')
	        	$this->params['itemnav2'] = ['label' => '<a class="menuHorarios" href="index.php?r=horarioexamen/completoxcurso&division='.$paramdivision->id.'&vista=materias&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>'];
	        else
	        	$this->params['itemnav2'] = ['label' =>   '<a class="menuHorarios" href="index.php?r=horarioexamen/completoxcurso&division='.$paramdivision->id.'&vista=docentes&col='.$col.'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>'];
*/?>
<div class="horarioxcurso-view">

	<?php  
 $js=<<< JS
     $('[rel="tooltip"]').tooltip();
JS;

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

    <h1><?= (Yii::$app->user->identity->role != Globales::US_HORARIO) ? Html::encode($this->title).'    <span class="badge">'.$txt.'</span>' : '' ?>
    <?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
    <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/panelprincipal&col='.$sem.'"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div class="pull-right">
	        <?php 
	        if($vista == 'docentes')
	        	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxcurso&division='.$paramdivision->id.'&vista=materias&sem='.$sem.'"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
	        else
	        	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxcurso&division='.$paramdivision->id.'&vista=docentes&sem='.$sem.'"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/menuxdivision"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
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
			echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxcurso&division='.$paramdivision->id.'&vista=docentes&sem='.$sema.'"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';
		
		}else
		echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';

			
		
			?>
</div>    
<div  class="pull-left">
		<?php 
			if($semn != null){
				$semn = $semn->id;
			echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/completoxcurso&division='.$paramdivision->id.'&vista=docentes&sem='.$semn.'"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';
		
			}else
			echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';

				?>
</div> 
   
</h1>
    <div class="clearfix" style="padding-bottom: 10px;"></div>	
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
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

	  <?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        //'filterModel' => $searchModel,
		        'condensed' =>true,
		        'striped' =>true,
		        'responsiveWrap' => false,
		        'summary' => false,
		        'rowOptions' => function($model) use($listdc) {

		        	try {
            			$cant = array_count_values($listdc)[$model->id];
            			if($cant > 1)
            				return ['class' => 'danger'];
            		} catch (Exception $e) {
            			return ['class' => 'danger'];
            		}

		            
		        },
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],

		            [
		            	'class' => 'kartik\grid\BooleanColumn',
		            	'label' => '',
		            	'visible' => (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_HORARIO]) && $prt==0) ? true : false,
		            	'value' => function($model) use($listdc) {
		            		//return var_dump(array_count_values($listdc));
		            		try {
		            			if(array_count_values($listdc)[$model->id]>1)
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
		            	'value' => function($model) use ($sem, $prt) {
		            		if($prt == 0)
		            			return Html::a($model->docente0->apellido.', '.$model->docente0->nombre, Url::to(['horarioexamen/completoxdocente', 'docente' => $model->docente, 'col' => 0]));
		            		else
		            			return $model->docente0->apellido.', '.$model->docente0->nombre;
		            	}

		            ],

		            

		            
		        ],
	    	]); ?>
    

</div>

<?php $this->registerJs($js, yii\web\View::POS_READY); ?>

