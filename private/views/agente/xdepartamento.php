<?php

use app\models\Departamento;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de docentes en horario';
$anios=ArrayHelper::map($anios,'id','nombre');
$deptos=ArrayHelper::map($deptos,'id','nombre');
$anio = $modelcatedra->aniolectivo;
$depto = $modelactividad->departamento;
?>
<div class="horario-index">

    <?php $form = ActiveForm::begin(); ?>
    <?php 

    echo $form->field($modelcatedra, 'aniolectivo')->widget(Select2::classname(), [
        'data' => $anios,
        'options' => ['placeholder' => 'Seleccionar...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo $form->field($modelactividad, 'departamento')->widget(Select2::classname(), [
        'data' => $deptos,
        'options' => ['placeholder' => 'Seleccionar...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('<div class="glyphicon glyphicon-search"></div> Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::PDF => [
                'label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => ''],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
                
                //'alertMsg' => false,
            ],

            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' =>'Departamento',
                'group' => true,
                'value' => function($model) use($depto){
                    return Departamento::findOne($depto)->nombre;
                }
            ],

            [
                'label' =>'Legajo',
                //'group' => true,
                'attribute' => 'legajo',
                'value' => function($model) use($anio){
                    return $model->legajo;
                }
            ],

            
            [
                'label' =>'Documento',
                //'group' => true,
                'value' => function($model) use($anio){
                    return $model->documento;
                }
            ],
            [
                'label' =>'Docente',
                //'group' => true,
                'value' => function($model) use($anio){
                    return $model->apellido.', '.$model->nombre;
                }
            ],
            [
                'label' =>'Teléfono',
                //'group' => true,
                'value' => function($model) use($anio){
                    return $model->telefono;
                }
            ],
            
           
            
            [
                'label' =>'Mail',
                //'group' => true,
                'value' => function($model) use($anio){
                    return $model->mail;
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],

            
            
            
            /*[
                'label' =>'',
                'group' => true,
                'attribute' => 'diasemana0.nombre',
            ],
            [
                'label' =>'',
                'attribute' => 'hora0.nombre',
            ],*/
            
            //'tipomovilidad0.nombre',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>