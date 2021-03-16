<?php

use app\config\Globales;
use app\models\Agente;
use app\models\Docentexdepartamento;
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

        <?php
              if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_PRECEPTOR])){
            ?>
          <div class="col-md-3"> 
              <?= 
                Html::a('<span class="'.$classlogo.' glyphicon glyphicon-book"></span><h2>Libro</h2><span class="label label-purple">AULA</span>',

              

                ['/libroclase/clasediaria'],

              [

                  //'id' => 'modalButtonIngreso',
                  'class' => $classclient,
                  // modalCall

              ]);
              ?>

          </div>
        <?php
              }
        ?>
        

        <?php
          if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_PRECEPTOR])){
        ?>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-education"></span><h2>Espacios</h2><span class="label label-primary">CURRICULARES</span>',

           ['/curriculares/menuopciones'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
        </div>
      <?php
          }
      ?>
      <?php
          if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_PRECEPTOR])){
        ?>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-time"></span><h2>Panel</h2><span class="label label-info">HORARIOS</span>',

           

            ['/horario/menuopcionespublic'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
      <?php
          }
      ?>
       <?php
          if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_MANTENIMIENTO])){
        ?>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-wrench"></span><h2>Tareas</h2><span class="label label-info">MANTENIMIENTO</span>',

           

            ['/tareamantenimiento'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>
     <?php
          }
     ?>
      <div class="col-md-3"> 
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-modal-window"></span><h2>Declaraciones</h2><span class="label label-warning">JURADAS</span>',

           

            ['/declaracionjurada'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);
          ?>

      </div>

      <?php
          if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_PRECEPTOR])){
        ?>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-open-file"></span><h2>Formularios</h2><span class="label label-success">FONID</span>',

           ['/fonid'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
        </div>
      <?php
          }
      ?>

<?php

      $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
      try {
        $depto = Docentexdepartamento::find()->where(['agente' => $persona->id])->count();
      } catch (\Throwable $th) {
        //throw $th;
        $depto = 0;
      }
      
      //$depto = 0;
      
          if(in_array(Yii::$app->user->identity->username, Globales::authttemas) || $depto>0){
        ?>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-book"></span><h2>Administrar</h2><span class="label label-danger">PROGRAMAS</span>',

           ['/libroclase/programa/actividades'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
        </div>
      <?php
          }
      ?>

      <?php
      if(in_array(Yii::$app->user->identity->username, Globales::mones)){
        ?>
        <div class="col-md-3">           
          <?= 
            Html::a('<span class="'.$classlogo.' glyphicon glyphicon-time"></span><h2>H. Académico</h2><span class="label label-default">MONES 2.0</span>',

           ['/mones/monalumno'],

           [

               //'id' => 'modalButtonIngreso',
               'class' => $classclient,
               // modalCall

           ]);

          ?>
      
        </div>
      <?php
          }
      ?>
     
      </div>
