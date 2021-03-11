<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Semana */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $semanasorigen = ArrayHelper::map($semanasorigen, 'id', function($model){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy').' al '.Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
        
    });
    
?>

<div class="caso-form">
<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
$inicio = Yii::$app->formatter->asDate($sem->inicio, 'dd/MM/yyyy')
?>
<h3>Semana de destino: <?= $inicio ?></h3>

<?php $form = ActiveForm::begin(['action' => Url::to('index.php?r=semana/copiardesde&origen='.$origen)]); ?>

   <?= 

        $form->field($model, 'semana')->widget(Select2::classname(), [
            'data' => $semanasorigen,
            'options' => [
                'placeholder' => 'Seleccionar...'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Semana de origen:');

    ?>
    
    
    <div class="form-group">
        <?= Html::submitButton('Generar', ['class' => 'btn btn-success', "name" => "btn_submit_semana", "value" => $semana, 
        'data' => [
            'confirm' => 'Se copiará la semana desde otra, sobrescribiendo cualquier cambio realizado en la presente semana. ¿Desea proceder?',
        ]]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
