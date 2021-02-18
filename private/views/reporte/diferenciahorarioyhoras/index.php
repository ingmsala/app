<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AgenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Diferencia de Horas de la materia vs Horario';
//$this->params['breadcrumbs'][] = $this->title;
$anios=ArrayHelper::map($anios,'id','nombre');

?>
<div class="agente-index">
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

    

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => ($dataProvider->totalCount > 0) ? GridView::TYPE_DANGER : GridView::TYPE_SUCCESS,

            'heading' => Html::encode($this->title)
            
            ],

         'toolbar'=>[
            
            '{export}',
            
        ],
        'floatHeader'=>true,
        'summary'=>false,
        'exportConfig' => [
            
            //GridView::HTML => [// html settings],
            GridView::PDF => ['label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => 'Portable Document Format'],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
            ],
        ],

        'columns' => [
            
            
            //'id',
            'division',
            'materia',
            [
                'label' => 'Horas de la Materia',
                'value' => function($model){
                    return $model['horasmat'];
                }
            ],
            [
                'label' => 'Cant. en el horario',
                'value' => function($model){
                    return $model['horashorario'];
                }
            ],
            
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'hiddenFromExport' => true,
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                '?r=horario/completoxcurso&division='.$model['divid'].'&vista=docentes');


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>