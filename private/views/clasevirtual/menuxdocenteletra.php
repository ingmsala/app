<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Seleccione un docente';
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="index.php?r=clasevirtual/menuxletra" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>'];
?>
<div class="row" style="padding-bottom: 10px;">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
	 <div style="display: <?= $userhorario ?>;">
    	<div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
	        ?>
	    </div>
	    <div  class="pull-right">
	        <?php 
	          	echo  '<a class = "btn btn-default" href="index.php?r=clasevirtual/menuxletra"><center><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><br />Volver</center></a>';
	        ?>
	    </div>
	</div>
</div>
<div class="row">
        <?= 
    $echodiv;
     ?>
    </div>