<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $aniolectivos = ArrayHelper::map($aniolectivos, 'id', 'nombre');
    $areas = ArrayHelper::map($areas, 'id', 'nombre');
?>

<div class="caso-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="width: 50%;">
        <?= 
            $form->field($model, 'inicio')->widget(DatePicker::classname(), [
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

    <?= $form->field($model, 'resolucion')->textInput(['maxlength' => true]) ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= 

                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                    'data' => $aniolectivos,
                    'options' => ['placeholder' => 'Seleccionar...', 'id' => 'aniolectivo_id'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);

            ?>

            <?php echo $form->field($model, 'matricula')->widget(DepDrop::classname(), [
                                            'type' => DepDrop::TYPE_SELECT2,
                                            //'name' => 'catedra',
                                            
                                            'options' => ['id'=>'matricula-id'],
                                            'pluginOptions' => [
                                            'depends'  => ['aniolectivo_id'],
                                            'placeholder' => 'Seleccionar...',
                                            'url' => Url::to(['/edh/caso/matriculas'])
                                            ]
                                        ]);  
            ?>

            <?php echo $form->field($modelSolicitud, 'demandante')->widget(DepDrop::classname(), [
                                            'type' => DepDrop::TYPE_SELECT2,
                                            //'name' => 'catedra',
                                            
                                            'options' => ['id'=>'demandante-id'],
                                            'pluginOptions' => [
                                            'depends'  => ['matricula-id', 'aniolectivo_id'],
                                            'placeholder' => 'Seleccionar...',
                                            'url' => Url::to(['/edh/caso/demandantes'])
                                            ]
                                        ]);  
            ?>
        </div>
    </div>

    <?= 

        $form->field($modelSolicitud, 'areasolicitud')->widget(Select2::classname(), [
            'data' => $areas,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>
    

    
    

   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
