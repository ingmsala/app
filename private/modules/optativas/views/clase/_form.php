<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;
use kartik\switchinput\SwitchInput;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

$this->registerJs("


  $(document).ready(function() { 
            $('#hr').change(function() {
            	var hc;
            	hc = $('#hr').val() * 1.66666666;
                hc = Math.round(hc * 100) / 100
            	$('#hc').val(hc);
            }); 
        });

");

?>


<?php $tipos=ArrayHelper::map($tiposclase,'id','nombre'); ?>
<?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre']; ?>
<?php $conf = [ 0 => 'A definir', 1 => 'Confirmada']; ?>

<div class="clase-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default" style="width:50%;">
        <div class="panel-heading">Fecha y Hora <span data-toggle="tooltip" title="En caso de no estar definida la fecha, seleccionar un mes aproximado del dictado de la clase" class="glyphicon glyphicon-info-sign"></span></div>
        <div class="panel-body">

            <?= $form->field($model, 'fechaconf')->dropDownList($conf, ['id' => 'cmbconf',

                'onchange'=>'
                                var conf = document.getElementById("cmbconf").value;
                                if(conf==0){
                                    $("#divsindef").show();
                                    $("#divconf").hide();
                                }else{
                                    $("#divconf").show();
                                    $("#divsindef").hide();
                                }

                ',

            ]); ?>
            <div id="divsindef" <?php if($model->fechaconf==1) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
                <?= Html::dropDownList('meses', $selection = $mesx, $meses, ['prompt' => '(Seleccionar)', 'id' => 'meses', 'class' => 'form-control']);?>
            </div>
            
            <div id="divconf" <?php if($model->fechaconf==0) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
                <?= 
                $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                    //'name' => 'dp_3',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    //'value' => '23-Feb-1982',
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        
                    ],
                    
                ]); ?>

                <?= $form->field($model, 'hora')->widget(TimePicker::classname(), [

                'pluginOptions' => [
                        
                        'showMeridian' => false,
                        'minuteStep' => 1,
                        'defaultTime' => false,

                    ]

                ]); ?>
            </div>
            


        </div>
    </div>
     <div style="width: 40%;">
   

</div>

    <?= $form->field($model, 'tipoclase')->dropDownList($tipos, ['prompt'=>'Seleccionar...']); ?>
    <div class="panel panel-default" style="width:50%;">
		<div class="panel-heading">Convertir a hora cátedra <span data-toggle="tooltip" title="Sólo se guarda el valor de la hora cátedra" class="glyphicon glyphicon-info-sign"></span></div>
		<div class="panel-body">
	    	<label>Hora reloj</label>
	    	<?= Html::input('text', 'username','', ['id'=>'hr', 'class' => 'form-control']) ?><br>
	    	<?= $form->field($model, 'horascatedra')->textInput(['maxlength' => true, 'id'=>'hc']) ?>


		</div>
	</div>
    
    <?= $form->field($model, 'tema')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
