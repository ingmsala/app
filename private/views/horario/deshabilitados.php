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

$this->title = 'Horarios con movilidad deshabilitada';
$anios=ArrayHelper::map($anios,'id','nombre');
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
            

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' =>'Materia',
                'group' => true,
                'attribute' => 'catedra0.actividad0.nombre',
            ],
            [
                'label' =>'Agente',
                'group' => true,
                'value' => function($model){
                    $cat = $model->catedra0;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6){
                            $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
           
            [
                'label' => 'División',
                'group' => true,
                'format' => 'raw',
                'value' => function($model){
                        
                            return Html::a($model->catedra0->division0->nombre, Url::to(['horario/completoxcurso', 'division' => $model->catedra0->division, 'vista' => 'docentes']));
                         
                }

            ],
            
            
            [
                'label' =>'',
                'group' => true,
                'attribute' => 'diasemana0.nombre',
            ],
            [
                'label' =>'',
                'attribute' => 'hora0.nombre',
            ],
            
            //'tipomovilidad0.nombre',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>