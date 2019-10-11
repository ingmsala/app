<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Seleccione una opción';

$usph = (Yii::$app->user->identity->username == 'pantallahorarios');
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
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-user"></span><h2>Horario</h2><h3>POR DOCENTE</h3><span class="label label-info">'.$infoexamen.'</span>',

           ['menuxletra', 'col'=>$col],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
      </div>
      <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-calendar"></span><h2>Horario</h2><h3>POR DÍA</h3><span class="label label-info">'.$infoexamen.'</span>',

           ['menuxdia', 'col'=>$col],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
          
      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-sd-video"></span><h2>Horario</h2><h3>POR DIVISIÓN</h3><span class="label label-info">'.$infoexamen.'</span>',

           

           ['menuxdivision', 'col'=>$col],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-1"></div>
    </div>