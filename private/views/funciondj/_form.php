<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;

?>

<div class="funciondj-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'publico')->widget(Select2::classname(), [
            'data' => [1=>'Pública', 2=>'Privada'],
            'hideSearch' => true,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==2) {
                            document.getElementById("depid").style.display = "none";
                            $( "#'.Html::getInputId($model, 'dependencia').'" ).val( "privada" );
                        }else{
                            
                            document.getElementById("depid").style.display = "block";
                            $( "#'.Html::getInputId($model, 'dependencia').'" ).val( null );

                        }
                        
                }',
            ]
        ]);

    ?>

<div id="depid" <?= ($model->publico == 2) ? 'style="display:none"' : 'style="display:block"'?> >

    <?php

        echo $form->field($model, 'dependencia')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => '', "autocomplete"=>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => array_column($reparticiones,'dependencia'),
                    'limit' => 10
                ]
            ]
        ]);
    ?>

</div>
    
    <?php

        echo $form->field($model, 'reparticion')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => '', "autocomplete"=>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => array_column($reparticiones,'reparticion'),
                    'limit' => 10
                ]
            ]
        ]);
    ?>
    
    <?php

        echo $form->field($model, 'cargo')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => '', "autocomplete"=>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => array_column($reparticiones,'cargo'),
                    'limit' => 10
                ]
            ]
        ]);
    ?>

    <?= $form->field($model, 'horas')->textInput() ?>

    <?= $form->field($model, 'licencia')->dropDownList([1=>'No', 2=>'Sí'], ['prompt'=>'Seleccionar...']); ?>


    <div class="form-group">
        
        

        <?php
    if(isset($update)){

    
?>
    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ]) ?>

    

<?php
    }
?>
<div class="pull-right">
<?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
