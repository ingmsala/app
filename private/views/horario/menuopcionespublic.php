<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;
use app\models\Parametros;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Seleccione una opción';
$this->params['itemnav'] = ['label' => '<a class="menuHorarios" href="'.Url::to('index.php?r=personal/menuprincipal').'" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Menú</center></a>'];

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
        
        <div class="col-md-3">           
          <?php
          
          if(Parametros::findOne(5)->estado == 1)
            $urlclases = ['/horario/horarioclasespublic'];
          else
            $urlclases = ['/horariogenerico/horariogeneric/horarioclasespublic'];
            
            echo Html::a('<span class="'.$classlogo.' glyphicon glyphicon-time"></span><h2>Horario</h2><span class="label label-primary">CLASES</span>',
            $urlclases,

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

           

            ['/horarioexamen/horariostrimestrales', 'col' => 0],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-copyright-mark"></span><h2>COLOQUIOS</h2><span class="label label-success">Marzo 2021</span>',

           

            ['/horarioexamen/horariostrimestrales', 'h' => $h, 'agente' => $agente, 'col' => 1],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      
    </div>
    <div class="row contpanelprincipal">
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

      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-tags"></span><h2>Citación</h2><span class="label label-warning">EXAMEN DE INGRESO</span>',

           

           Url::to('https://drive.google.com/file/d/1GEYn-2PvskUrsft5RR5kLF15Bf8u-0SH/view?usp=sharing', $schema = true),

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
        <div class="col-md-3">
          <?= '';
            /*Html::a('<span class="'.$classlogo.' glyphicon glyphicon-ruble"></span><h2>Exámenes</h2><span class="label label-warning">FEBRERO / MARZO</span>',

           

           ['marzo'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);*/
          ?>
        </div>
      </div>