<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Clasediaria */
/* @var $form yii\widgets\ActiveForm */

$modelidadesclase = ArrayHelper::map($modelidadesclase, 'id', 'nombre');
$horas = ArrayHelper::map($horas, 'id', 'nombre');
$tiposcurricula = ArrayHelper::map($tiposcurricula, 'id', 'nombre');



?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalagregartema',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>



<div class="clasediaria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="divfecha">
        <?= 
            $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                'pluginEvents' => [
                        
                    "changeDate" => 'function(e) {  
                        cat = '.$model->catedra.';

                        var d = e.date;
                        var day = d.getDate();
                        var month = d.getMonth() + 1;
                        var year = d.getFullYear();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        var date = year + "-" + month + "-" + day;
                        console.log(date);
                        
                        $.get("index.php?r=libroclase/clasediaria/gethorashorario&cat="+cat+"&fecha="+date, function( data ) {
                            $( "select#horaxclase-hora" ).html( data );
                            console.log(data);
                        });

                     }',
                    
                ],
                
            ]);
        ?>
    </div>

    <?= 

        $form->field($model, 'modalidadclase')->widget(Select2::classname(), [
            'data' => $modelidadesclase,
            'options' => ['placeholder' => 'Seleccionar...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                
            ],
        ]);

    ?>

    <?= 

        $form->field($modelhxc, 'hora')->widget(Select2::classname(), [
            'data' => $horasaj,
            'options' => ['placeholder' => 'Seleccionar...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
                
            ],
        ]);

    ?>

    <?= 

        $form->field($model, 'tipocurricula')->widget(Select2::classname(), [
            'data' => $tiposcurricula,
            'options' => ['placeholder' => 'Seleccionar...', 
            
                'onchange'=>'
                    tipo = $(this).val();
                    if(tipo == 1){
                        $( "div#divtemasclase" ).show();
                    }else{
                        $( "div#divtemasclase" ).hide();
                    }
                    
                    
                '
            ],
            'pluginOptions' => [
                'allowClear' => true,
                
            ],
        ]);

    ?>
    <div class="clearfix"></div>

    <div id="divtemasclase"  class="panel panel-default">
    <div class="panel-heading">Temas de clase</div>
        <div class="panel-body">
            <?=
                Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar o quitar tema', ['value' => Url::to(['/libroclase/temaunidad/porunidad', 'cat' => $model->catedra, 'detuni' => 1, 'actividad' => $actividad]), 'title' => 'Agregar tema', 'class' => 'btn btn-info amodalagregartema']);
            ?>

            <div id="temasseleccionados"></div>
        </div>
    </div>
    

    <div id="forminputs">
    </div>

    <div id="forminputstipo-des">
    </div>
    

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
