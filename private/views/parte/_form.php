<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $model app\models\Parte */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="parte-form">

    <?php $form = ActiveForm::begin([
    	'id' => 'create-update-detalle-catedra-form',
    ]); ?>

    <?php $listPreceptoria=ArrayHelper::map($precepx,'id','nombre');?> 
    <?php $listTipoParte=ArrayHelper::map($tiposparte,'id','nombre');?>
    
    

  		
	   <div style="width: 50%;">
    <?= 
$form->field($model, 'fecha')->widget(DatePicker::classname(), [
    //'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //'value' => '23-Feb-1982',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy',
        //'endDate' => "1d",
        
    ],
    
]); ?>

</div>

    
    <?= $form->field($model, 'preceptoria')->dropDownList($listPreceptoria, ['prompt'=>'Seleccionar...','style' => 'width:50%']); ?>


    <?= $form->field($model, 'tipoparte')->dropDownList($listTipoParte, ['prompt'=>'Seleccionar...','style' => 'width:50%']); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id' => 'btnausentes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<?php 


Pjax::begin(['id' => 'test2', 'timeout' => 5000]); ?>
    <div id="devok">
    
</div>
    
<?php Pjax::end(); ?>

<?php if (in_array (Yii::$app->user->identity->role, [1])): ?>
            <?=Html::a(
                '<span class="glyphicon glyphicon-ok"></span> BAckup',
                false,
                [
                    'class' => 'btn btn-primary',
                    'id' => 'btnausentes2',
                    
                ]
            );
    ?>
        <?php endif ?>

 
