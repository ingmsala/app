<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;

?>

<div class="funciondj-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php

        echo $form->field($model, 'reparticion')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Filter as you type ...', "autocomplete"=>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => array_column($reparticiones,'reparticion'),
                    'limit' => 10
                ]
            ]
        ]);
    ?>
    
    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'declaracionjurada')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
