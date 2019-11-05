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
        
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-time"></span><h2>Horario</h2><span class="label label-primary">CLASES</span>',

           ['/horario/panelprincipal'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
      </div>
      
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-calendar"></span><h2>Horarios</h2><span class="label label-info">TRIMESTRALES</span>',

           

            ['/horarioexamen/panelprincipal', 'col' => 0],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-copyright-mark"></span><h2>Horarios</h2><span class="label label-success">COLOQUIOS</span>',

           

            ['/horarioexamen/panelprincipal', 'col' => 1],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-ruble"></span><h2>Exámenes</h2><span class="label label-danger">PREVIOS</span>',

           

           ['pdfprevios'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
    </div>