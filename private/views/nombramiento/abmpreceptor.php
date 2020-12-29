<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nombramiento-form">

    <?php $form = ActiveForm::begin(); ?>

 
    <?php $listpreceptor=ArrayHelper::map($preceptor,'id',function($model){
            if($model->agente0->id == 77) //jaime
                return $model->agente0->apellido.', '.$model->agente0->nombre.' '.$model->nombre;
            else
                return $model->agente0->apellido.', '.$model->agente0->nombre;
    }); ?>
    

    

    <?= 

        $form->field($model, 'id')->widget(Select2::classname(), [
            'data' => $listpreceptor,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Agente');

    ?>


    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>