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

$this->title = 'Horario de Clases: '.$paramdivision->nombre;
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="index.php?r=horario/menuxdivision" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];

if($vista == 'docentes')
	        	$this->params['itemnav2'] = ['label' => '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=materias" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>'];
	        else
	        	$this->params['itemnav2'] = ['label' =>   '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=docentes" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>'];
?>
<div class="horario-view">

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
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div class="pull-right">
	        <?php 
	        if($vista == 'docentes')
	        	echo  '<a class = "btn btn-default" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=materias"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
	        else
	        	echo  '<a class = "btn btn-default" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=docentes"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/menuxdivision"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/printxcurso&division='.$paramdivision->id.'&vista=materias"><center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center></a>';;
	        ?>
	    </div>
    </div>
    
    
   
</h1>
    <div class="clearfix" style="padding-bottom: 10px;"></div>	
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'responsiveWrap' => false,
		        'condensed' => ($pr==0) ? false : true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'Horario',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '0',
		                'value' => function($model) use ($pr){
		                	if ($pr == 0)
		                		return '<span class="badge">'.$model['0'].'</span>';
		                	return $model['0'];
		                }
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
		                'label' => 'Miercoles',
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
		            

		            
		        ],
	    	]); ?>

	  <?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        //'filterModel' => $searchModel,
		        'responsiveWrap' => false,
		        'summary' => false,
		        'condensed' => ($pr==0) ? false : true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		            
		            [
		            	'label' => 'Materia',
		            	'value' => function($model){
		            		return $model->catedra0->actividad0->nombre;
		            	}

		            ],

		            [
		            	'label' => 'Docente',
		            	'format' => 'raw',
		            	'value' => function($model) use($pr){
		            			if($pr==0)
		            				return Html::a($model->docente0->apellido.', '.$model->docente0->nombre, Url::to(['horario/completoxdocente', 'docente' => $model->docente]));
		            		 	else
		            		 		return $model->docente0->apellido.', '.$model->docente0->nombre;
		            	}

		            ],

		            [
	                'class' => 'kartik\grid\ActionColumn',

	                'template' => '{viewdetcat}',
	                'visible' => (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA]) && ($pr==0)) ? true : false,
	                
	                'buttons' => [
	                    'viewdetcat' => function($url, $model, $key){
	                        return Html::a(
	                            '<span class="glyphicon glyphicon-eye-open"></span>',
	                            '?r=detallecatedra/updatehorario&or=hc&id='.$model['id']);
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

