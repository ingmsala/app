<?php

use kartik\file\FileInput;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $creadores=ArrayHelper::map($creadores,'id', function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );
?>
<?php $prioridades =ArrayHelper::map($prioridades,'id', 'nombre');?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'estadoticket')->textInput() ?>

    <?= 

        $form->field($model, 'agente')->widget(Select2::classname(), [
            'data' => $creadores,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= 

        $form->field($modelasignacion, 'agente')->widget(Select2::classname(), [
            'data' => $asignaciones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>

    

    <?= 

        $form->field($model, 'prioridadticket')->widget(Select2::classname(), [
            'data' => $prioridades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>

    <?php

        echo '<label class="control-label">Adjuntar</label>';
        echo FileInput::widget([
            'model' => $modelajuntos,
            'attribute' => 'image',
            //'options' => ['multiple' => true]
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php

        if($origen == 'update'){
            echo '<label class="control-label">Archivos adjuntados</label>';
            echo $this->renderAjax('/adjuntoticket/index', [
                'searchModel' => $searchModelAdjuntos,
                'dataProvider' => $dataProviderAdjuntos,
               
            ]);


        }

    ?>

    

    

</div>
