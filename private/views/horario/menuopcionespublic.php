<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Seleccione una opción';
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="'.Url::to('index.php?r=horario/login').'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><br />Salir</center></a>'];

$usph = false;
if($usph){
  $classlogo ='logo3';
  $classclient ='client3';
}
else{
  $classlogo = 'logo2';
  $classclient ='client';
}

?>
<div class="row contpanelprincipal">
        <div class="col-md-2"></div>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-user"></span><h2>Horario</h2><span class="label label-primary">CLASES</span>',

           ['/horario/horarioclasespublic', 'h' => $h, 'docente' => $docente],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
      </div>
      
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-sd-video"></span><h2>Horarios</h2><span class="label label-info">TRIMESTRALES</span>',

           

            ['/horarioexamen/horariostrimestrales', 'h' => $h, 'docente' => $docente, 'col' => 0],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-sd-video"></span><h2>Horarios</h2><span class="label label-success">COLOQUIOS</span>',

           

            ['/horarioexamen/horariostrimestrales', 'h' => $h, 'docente' => $docente, 'col' => 1],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-2"></div>
    </div>