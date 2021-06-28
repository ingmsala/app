<?php

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\form\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Proveedorpago */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proveedorpago-form">

    <?php $form = ActiveForm::begin(['id' => 'ajaxalgo','enableAjaxValidation' => true]); ?>

    <?php

            echo FormGrid::widget([
            
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
                    'attributes'=>[       // 2 column layout
                        
                        'nombre'=>['type'=>Form::INPUT_TEXT],
                        'cuit'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\yii\widgets\MaskedInput', 
                            'options'=>['mask' => '99-99999999-9',], 
                        ],
                        
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
                    'attributes'=>[       // 2 column layout
                        
                        'mail'=>['type'=>Form::INPUT_TEXT],
                        'telefono'=>['type'=>Form::INPUT_TEXT],
                        'direccion'=>['type'=>Form::INPUT_TEXT],
                        
                        
                    ]
                ],
            ]

        ]);
    ?>

<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
