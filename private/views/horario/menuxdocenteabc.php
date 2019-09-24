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

$this->title = 'Seleccione un docente';

?>
<?php  
 $js=<<< JS
     $('#finddoc').select2('open');
     $('.select2-search__field').addClass("nose");
     $('.select2-results').addClass("nose2");
JS;

?>
    <div style="display: none;">
         <div class="pull-right" style="margin-bottom: 10px;margin-left: 5px;">
            <?php 
              	echo  '<a class="menuHorarios" href="index.php?r=horario/panelprincipal" style="font-size: 12hv;"><center><span class="glyphicon glyphicon-home" aria-hidden="true"></span><br />Inicio</center></a>';
            ?>
        </div>
    </div>

<div class="clearfix"></div>
<?php $form = ActiveForm::begin(); ?>

         <?= 

        $form->field($model, 'apellido')->widget(Select2::classname(), [
            'data' => $listdocentes,
            'options' => ['placeholder' => 'Seleccionar...', 'id' => 'finddoc'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Docente');

    ?>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'client']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php $this->registerJs($js, yii\web\View::POS_READY); ?>