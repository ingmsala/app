<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Seleccione una división';
?>
<div class="row">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
	 
</div>
<div class="row" style="padding-bottom: 10px;">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
	 <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          //	echo  '<a class = "btn btn-default" href="index.php?r=horarioexamen/panelprincipal&col='.$col.'"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	
	          //	echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir Todos</center>', Url::to(['printcursos', 'division' => '', 'all' => true, 'col' => $col]),['class' => 'btn btn-default'])
	        ?>
	    </div>
	</div>
</div>
<div class="row">

        <?= 
    $echodiv;
     ?>
    </div>