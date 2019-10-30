<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */
/* @var $form yii\widgets\ActiveForm */

$listestados = ArrayHelper::map($estados, 'id', 'nombre');
$listtipos = ArrayHelper::map($tipos, 'id', 'nombre');

?>

<div class="seguimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tiposeguimiento')->widget(Select2::classname(), [
            'data' => $listtipos,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==1) {
                          
                           $( "#divestado" ).hide();
                           
                          
                        }else{
                            $( "#divestado" ).show();
                           
                        }
                        
                }',
            ]
        ]);

    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => '8']) ?>

    <div id="divestado" style="display: none;">
    	<?= $form->field($model, 'estadoseguimiento')->dropDownList($listestados, ['prompt'=>'Seleccionar...']); ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
