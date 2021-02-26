<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Solicitudinscripext */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $turnoexamen=ArrayHelper::map($turnoexamen,'id','nombre'); ?>
<?php $actividades=ArrayHelper::map($actividades,'id','nombre'); ?>

<div class="solicitudinscripext-form" style="background-color: #F9F9F9;padding:10px;">

    <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="divfecha">
        <?= 
            $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                //'name' => 'dp_3',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                //'value' => '23-Feb-1982',
                'readonly' => true,
                'disabled' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    
                ],
                
            ]);
        ?>

    </div>

    <?= 

        $form->field($model, 'turno')->widget(Select2::classname(), [
            'data' => $turnoexamen,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= 

        $form->field($modelDetalle, 'actividad')->widget(Select2::classname(), [
            'data' => $actividades,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?php

    echo $form->field($modelAjuntos, 'image[]')->widget(FileInput::classname(), [
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

    /*echo '<label class="control-label">Adjuntar copia del DNI (actualizado y de ambos lados)</label>';
    echo FileInput::widget([
        'model' => $modelAjuntos,
        'attribute' => 'image[]',
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'overwriteInitial'=>false,
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]);*/

    ?>
    <br /> 

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
