<?php

use yii\helpers\Html;

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
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-education"></span><h2>Espacios</h2><span class="label label-primary">OPTATIVOS</span>',

           ['/optativas'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
      </div>
      
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-globe"></span><h2>Proyectos</h2><span class="label label-info">SOCIOCOMUNITARIOS</span>',

           

            ['/sociocomunitarios'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
     
      </div>
