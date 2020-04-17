<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HoraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Datos de Contacto de Estudiantes';

$alumnoslist=ArrayHelper::map($alumnos,'id',function($model){
    return $model->apellido.', '.$model->nombre;
});
?>
<div class="hora-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($alumno, 'id')->widget(Select2::classname(), [
            'data' => $alumnoslist,
            'options' => [
                'prompt' => '...',
                'id' => 'finddoc',
                
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Estudiante'); ?>

<div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php 
    
        if($dataProvider != null){

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
        
                    'apellido',
                    'nombre',
                    'parentezco',
                    'telefono',
        
                    
                ],
            ]);

        }
    ?>
</div>