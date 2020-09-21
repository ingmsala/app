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

<h2><?= ($decla == null) ? 'Sin declaración jurada' :

$decla->docente0->apellido.', '.$decla->docente0->nombre?></h2>
<h5><?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
echo  ($decla == null) ? '' :'Última declaración jurada: '.Yii::$app->formatter->asDate($decla->fecha, 'dd/MM/yyyy');

 ?></h5>

<?= ($decla == null) ? '' : GridView::widget([
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
		                'header' => 'Cargo',
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

</div>