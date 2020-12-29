<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Detallemodulo */
/* @var $form yii\widgets\ActiveForm */
$listespacios=ArrayHelper::map($espacios,'id',function($model){
    return $model->nombre.' - '.$model->piso;
});
$listhorarioclaseespaciales=ArrayHelper::map($horarioclaseespaciales,'id',function($model){
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    
    return Yii::$app->formatter->asDate($model->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($model->inicio, 'HH:mm').' - Código: '.$model->codigo;
});

$listcatedras=ArrayHelper::map($detallecatedras,'id',function($dc){
    
    $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
    
    return $dc->catedra0->actividad0->nombre.' - '.$doc;
});


?>

<div class="detallemodulo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'espacio')->widget(Select2::classname(), [
            'data' => $listespacios,
            'options' => [
                'placeholder' => 'Seleccionar...',
                
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Espacio");

    ?>
    <?= 

        $form->field($model, 'horarioclaseespecial')->widget(Select2::classname(), [
            'data' => $listhorarioclaseespaciales,
            'options' => [
                'placeholder' => 'Seleccionar...',
                'multiple' => $multiple,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Horarios");

    ?>

<?= 

$form->field($model, 'detallecatedra')->widget(Select2::classname(), [
    'data' => $listcatedras,
    'options' => [
        'placeholder' => 'Sin asignar',
        
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label("Materia - Agente");

?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
