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
$this->title = 'Horario de Clases: '.$paramdia->nombre;

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
		 <div class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
		        <?php 
		          	echo  '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
		        ?>
		    </div>
		    <div class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
		        <?php 
		        if($vista == 'docentes')
		        	echo  '<a class="menuHorarios" href="index.php?r=horario/completoxdia&dia='.$paramdia->id.'&vista=materias" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-book" aria-hidden="true"></span><br />Materias</center></a>';
		        else
		        	echo  '<a class="menuHorarios" href="index.php?r=horario/completoxdia&dia='.$paramdia->id.'&vista=docentes" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-education" aria-hidden="true"></span><br />Docentes</center></a>';
		        ?>
		    </div>
    </div>
    
    
   
</h1>
<?php //echo var_dump($provider) ?>
    <div class="clearfix"></div>	
	<?= GridView::widget([
		        'dataProvider' => $provider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'columns' => [
		            //['class' => 'yii\grid\SerialColumn'],
		            [
		                'label' => 'División',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                //'attribute' => '1',
		                'value' => function($model){
		                	return '<b>'.$model['1'].'</b>';
		                }
		            ],
		            [
		                'label' => '1°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '2',
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '2°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '3'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '3°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '4'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '4°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '5'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '5°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '6'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '6°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '7'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '7°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '8'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],

		            [
		                'label' => '8°',
		                'vAlign' => 'middle',
		                'hAlign' => 'center',
		                'format' => 'raw',
		                'attribute' => '9'
		                /*'value' => function($model){
		                	return var_dump($model);
		                }*/
		            ],
		            

		            
		        ],
	    	]); ?>

	  
    

</div>

<?php $this->registerJs($js, yii\web\View::POS_READY); ?>

