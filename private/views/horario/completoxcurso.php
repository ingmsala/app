<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\config\Globales;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

if($vista == 'docentes')
	$txt = 'Docentes';
else
	$txt = 'Materias';

$this->title = $alx->nombre.' - Horario de Clases: '.$paramdivision->nombre;
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="index.php?r=horario/menuxdivision" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];

if($vista == 'docentes')
	        	$this->params['itemnav2'] = ['label' => '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=materias" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>'];
	        else
	        	$this->params['itemnav2'] = ['label' =>   '<a class="menuHorarios" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=docentes" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>'];
?>

<?php
	if($otro == 1){
		echo '<div class="horario-view" style="background-color:#FFEEFF;">';
	}else{
		echo '<div class="horario-view">';
	}
?>


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
	        	echo  '<a class = "btn btn-default" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=materias&al='.$aniolec.'"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
	        else
	        	echo  '<a class = "btn btn-default" href="index.php?r=horario/completoxcurso&division='.$paramdivision->id.'&vista=docentes&al='.$aniolec.'"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/menuxdivision"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=horario/printxcurso&division='.$paramdivision->id.'&vista='.$vista.'&al='.$aniolec.'"><center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center></a>';;
	        ?>
	    </div>
    </div>
    
    
   
</h1>
	<?php
		if($preceptor != null){
			echo '<h4><i>Preceptor: '.$preceptor->agente0->apellido.', '.$preceptor->agente0->nombre.'</i></h4>';
		}
	?>
	<?php
		if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $pr<>1){
			$listaniolectivo=ArrayHelper::map($anioslectivos,'id','nombre'); 
			if(count($listaniolectivo)>0){
				$form = ActiveForm::begin();
				echo $form->field($model, 'aniolectivo')->dropDownList($listaniolectivo, ['onchange'=>'this.form.submit()']);
				ActiveForm::end();
			}else{
				echo '<div class="clearfix"></div>';
			}
			echo '<div class="pull-right">'.$publi.'</div>';
		}
	?>
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
						'headerOptions' => $colorheader,
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
						'attribute' => '2',
						'headerOptions' => $colorheader,
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Martes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => '3',
						'headerOptions' => $colorheader,
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Miércoles',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => '4',
						'headerOptions' => $colorheader,
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Jueves',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => '5',
						'headerOptions' => $colorheader,
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => 'Viernes',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
						'attribute' => '6',
						'headerOptions' => $colorheader,
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            

		            
		        ],
			]); ?>
		
		<p>
			<?php
			if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) && $pr<>1){
			 	Html::a('Horario contraturno', Url::to(['/horariocontraturno/create', 'division' => $paramdivision->id, 'al' => $alx->id]), ['class' => 'btn btn-success']);
			}
			 ?>

		</p>

		<?php
		$template = (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])) ? '{viewdetcat} {dj}' : '{viewdetcat}';
		$template2 = (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA])) ? '{viewdetcat} {dj} {delete}' : '{viewdetcat}';
	?>

		<?php GridView::widget([
		        'dataProvider' => $contraturnoProvider,
		        //'filterModel' => $searchModel,
		        'responsiveWrap' => false,
		        'summary' => false,
		        'condensed' => ($pr==0) ? false : true,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],

					[
		            	'label' => 'Día',
		            	'value' => function($model){
		            		return $model->diasemana0->nombre;
		            	}

		            ],

					[
		            	'label' => 'Hora',
		            	'value' => function($model){
							$inicio = explode(':', $model->inicio);
							$fin = explode(':', $model->fin);
		            		return $inicio[0].':'.$inicio[1].' a '.$fin[0].':'.$fin[1];
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
		            	'value' => function($model) use($pr, $alx){
		            			/*if($pr==0)
		            				return Html::a($model->agente0->apellido.', '.$model->agente0->nombre, Url::to(['horario/completoxdocente', 'agente' => $model->agente]));
		            		 	else*/
								 return $model->agente0->getNombreCompleto();
		            		 		
									 
		            	}

		            ],

					[
						'class' => 'kartik\grid\ActionColumn',
	
						'template' => $template2,
						'visible' => (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA]) && ($pr==0)) ? true : false,
						
						'buttons' => [
							'viewdetcat' => function($url, $model, $key) {

								return Html::a(
									'<span class="glyphicon glyphicon-pencil"></span>',
									'?r=horariocontraturno/update&or=hc&id='.$model->id);
							},
							
							'dj' => function($url, $model, $key) {

								return Html::button('<span class="glyphicon glyphicon-modal-window"></span>',
								['value' => Url::to('index.php?r=horario/declaracionhorario&dni='.$model->agente0->documento),
									'class' => 'modala btn btn-link', 'id'=>'modala']);
									
							},
	
							'delete' => function($url, $model, $key){
								
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['/horariocontraturno/delete', 'id' => $model->id]), ['data-confirm' => 'Esta seguro que desea eliminar el horario?', 'data-method' => 'post']);
	
	
						},
							
							
						]
	
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
		            	'label' => 'Agente',
		            	'format' => 'raw',
		            	'value' => function($model) use($pr){
		            			if($pr==0)
		            				return Html::a($model->agente0->apellido.', '.$model->agente0->nombre, Url::to(['horario/completoxdocente', 'agente' => $model->agente]));
		            		 	else
		            		 		return $model->agente0->apellido.', '.$model->agente0->nombre;
		            	}

		            ],

		            [
	                'class' => 'kartik\grid\ActionColumn',

	                'template' => $template,
	                'visible' => (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA]) && ($pr==0)) ? true : false,
	                
	                'buttons' => [
	                    'viewdetcat' => function($url, $model, $key){
	                        return Html::a(
	                            '<span class="glyphicon glyphicon-eye-open"></span>',
	                            '?r=detallecatedra/updatehorario&or=hc&id='.$model['id']);
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

