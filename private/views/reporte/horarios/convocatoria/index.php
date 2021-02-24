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

$this->title = 'Horarios Sujetos a Convocatoria';
$anios=ArrayHelper::map($anios,'id','nombre');
?>
<div class="horario-index">

    <?php $form = ActiveForm::begin(); ?>
    <?= 

    $form->field($modelCatedra, 'aniolectivo')->widget(Select2::classname(), [
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
                'value' => function($model){
                    if($model->catedra0->division0->turno == 1){
                        $h[1] = '7:15 a 7:55';
                        $h[2] = '8:00 a 8:40';
                        $h[3] = '8:45 a 9:25';
                        $h[4] = '9:30 a 10:10';
                        $h[5] = '10:20 a 11:00';
                        $h[6] = '11:05 a 11:45';
                        $h[7] = '11:50 a 12:30';
                        $h[8] = '12:35 a 13:15';
                    }elseif ($model->catedra0->division0->turno == 2) {
                        $h[1] = '13:30 a 14:10';
                        $h[2] = '14:15 a 14:55';
                        $h[3] = '15:00 a 15:40';
                        $h[4] = '15:45 a 16:25';
                        $h[5] = '16:35 a 17:15';
                        $h[6] = '17:20 a 18:00';
                        $h[7] = '18:05 a 18:45';
                        $h[8] = '18:50 a 19:30';
                    }
                    return $model->hora0->nombre.' ('.$h[$model->hora-1].')';
                }
            ],
            
            //'tipomovilidad0.nombre',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>