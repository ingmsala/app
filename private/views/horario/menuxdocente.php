<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */
$listdocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );

$this->title = 'Seleccione un agente';

?>
<?php  
 $js=<<< JS
     $('#finddoc').select2('open');
     $('.select2-search__field').addClass("nose");
     $('.select2-results').addClass("nose2");
JS;

?>
    <div class="row" style="padding-bottom: 10px;">
<?php $userhorario = (Yii::$app->user->identity->role == Globales::US_HORARIO)? "none" : "block" ?>
   <div style="display: <?= $userhorario ?>;">
      <div  class="pull-right">
          <?php 
              echo  '<a class = "btn btn-default" href="index.php?r=horario/panelprincipal"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
          ?>
      </div>
  </div>
</div>
<?php $form = ActiveForm::begin(); ?>

         <?= 

        $form->field($model, 'apellido')->widget(Select2::classname(), [
            'data' => $listdocentes,
            'options' => ['placeholder' => 'Seleccionar...', 'id' => 'finddoc'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Agente');

    ?>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'client']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php $this->registerJs($js, yii\web\View::POS_READY); ?>