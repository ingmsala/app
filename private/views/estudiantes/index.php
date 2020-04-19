<?php

use app\components\CardWidget;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HoraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tutores: Datos de Contacto';

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
                'prompt' => 'Seleccionar...',
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
            if($dataProvider->getTotalCount()>0){
                echo '<div class="clearfix"></div>';
                echo '<h3>Estudiante: '.$alumno->apellido.', '.$alumno->nombre.'</h3>';
                echo '<div class="clearfix"></div>';
                echo '<h4>Tutores</h4>';
                
                for ($i=0; $i < count($model); $i++) {
                    echo '<div class="col-md-4">';
                    echo DetailView::widget([
                        'model' => $model[$i],
                        'attributes' => [
                            
                            'nombre',
                            'apellido',
                            'mail',
                            'telefono',
                        ],
                    ]);
                    echo '</div>';
                }
                echo '<div class="clearfix"></div>';
                echo CardWidget::widget([
                    'dataProvider' => $dataProvider,
                    'grid' => 4,
                    'color' => 'primary',
                    'titulo' => [
                        'apellido',
                        'nombre'
                    ], 
                    'columnas' => 
                    [
                        'parentesco' => 'Parentesco',
                        'telefono' => 'Teléfono',
                        'mail' => 'Mail',
                        
                    ]
                ]);/*
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
            
                        'apellido',
                        'nombre',
                        'parentesco',
                        'telefono',
                        'mail'
            
                        
                    ],
                ]);*/
            }else{
                echo '<h3>No hay registros de tutores del estudiante</h3>';
            }
            

        }
    ?>
</div>