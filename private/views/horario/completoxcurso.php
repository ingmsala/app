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
    <div style="display: none;">
    	<div  class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
	        <?php 
	          	echo  '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
	        <?php 
	        if($vista == 'docentes')
	        	echo  '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=materias" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
	        else
	        	echo  '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=docentes" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
	        ?>
	    </div>
    </div>
    
    
   
</h1>
    <div class="clearfix"></div>	
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'columns' => [
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
		        'summary' => false,
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
		            	'value' => function($model){

		            		return $model->docente0->apellido.', '.$model->docente0->nombre;
		            	}

		            ],

		            [
	                'class' => 'kartik\grid\ActionColumn',

	                'template' => '{viewdetcat}',
	                'visible' => (Yii::$app->user->identity->role == Globales::US_HORARIO) ? false : true,
	                
	                'buttons' => [
	                    'viewdetcat' => function($url, $model, $key){
	                        return Html::a(
	                            '<span class="glyphicon glyphicon-eye-open"></span>',
	                            '?r=detallecatedra/updatehorario&id='.$model['id']);
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

