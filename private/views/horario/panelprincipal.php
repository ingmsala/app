<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Seleccione una opción';
?>
<div class="row" style="margin-top: 100px;">
        <div class="col-md-1"></div>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="logo glyphicon glyphicon-user"></span><h2>Horario</h2><h3>POR DOCENTE</h3>',

           ['menuxletra'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => 'client',
               // modalCall

           ]);

          ?>
      
      </div>
      <div class="col-md-3">           
          <?= 
            Html::a('<span class="logo glyphicon glyphicon-calendar"></span><h2>Horario</h2><h3>POR DÍA</h3>',

           ['menuxdia'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => 'client',
               // modalCall

           ]);

          ?>
          
      </div>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="logo2 glyphicon glyphicon-sd-video"></span><h2>Horario</h2><h3>POR DIVISIÓN</h3>',

           

           ['menuxdivision'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => 'client',
               // modalCall

           ]);
          ?>

      </div>
      <div class="col-md-3"></div>
    </div>