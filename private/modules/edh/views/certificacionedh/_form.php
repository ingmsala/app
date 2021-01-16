<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Certificacionedh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificacionedh-form">

<?php 
    $tiposcertificado = ArrayHelper::map($tiposcertificado, 'id', 'nombre');
    $tiposprofesional = ArrayHelper::map($tiposprofesional, 'id', 'nombre');
    
?>



    <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); ?>

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
                    
                ],
                
            ]);
        ?>

    </div>


    <?= 

        $form->field($model, 'tipoprofesional')->widget(Select2::classname(), [
            'data' => $tiposprofesional,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?php 
    
        echo $form->field($model, 'referente')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => $referentes,
                    'limit' => 10
                ]
            ]
        ]);

    ?>

    <?php 
        
        echo $form->field($model, 'institucion')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => $instituciones,
                    'limit' => 10
                ]
            ]
        ]);

    ?>

    <?= $form->field($model, 'contacto')->textInput(['maxlength' => true]) ?>

    <?= 

        $form->field($model, 'tipocertificado')->widget(Select2::classname(), [
            'data' => $tiposcertificado,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?php 
        
        echo $form->field($model, 'diagnostico')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Completar ...', 'autoComplete' =>"off"],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => $diagnosticos,
                    'limit' => 10
                ]
            ]
        ]);

    ?>

    <?php

        echo '<label class="control-label">Adjuntar</label>';
        echo FileInput::widget([
            'model' => $modelajuntos,
            'attribute' => 'image[]',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'overwriteInitial'=>false,
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]);

    ?>
    <br /> 

    <?= $form->field($model, 'indicacion')->textarea(['rows' => 6]) ?>

    

    

    



    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
