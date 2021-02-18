<?php

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
$anio = $model->aniolectivo;
?>
<div class="horario-index">

    <?php $form = ActiveForm::begin(); ?>
    <?= 

    $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
        'data' => $anios,
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
                'label' =>'Documento',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->documento;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            [
                'label' =>'Docente',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                            break;
                        }
                    }
                    return $doc;
                }
            ],

            [
                'label' =>'Materia',
                //'group' => true,
                'attribute' => 'actividad0.nombre',
            ],
           
            [
                'label' => 'División',
                //'group' => true,
                'format' => 'raw',
                'value' => function($model){
                        
                            return $model->division0->nombre;
                         
                }

            ],

            [
                'label' =>'Mail',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->mail;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            
            
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