<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte - Horas de Actividades por Cátedra';
$this->params['breadcrumbs'][] = $this->title;

$listActividades=ArrayHelper::map($actividades,'id', 'nombre');
?>
<div class="docente-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filter = false;
                            if(isset($param['Actividad']['id'])){
                                if($param['Actividad']['id']!=''){
                                    $filter = true;
                                    echo '<b> - Actividad: </b>'.$listActividades[$param['Actividad']['id']];
                                }
                            }
                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=reporte/horasmateriaxcatedra"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['index'],
                                    'method' => 'get',
                                ]); ?>

                            <?= 
                                
                                $form->field($model, 'id')->widget(Select2::classname(), [
                                    'data' => $listActividades,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Actividad");

                            ?>
                        
                            <div class="form-group">
                                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Resetear', ['class' => 'btn btn-default']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){

                        if ($model['horas_semanales'] !=$model['cantidad_vigente']){
                            return ['class' => 'danger'];
                        }
                        
                    },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
            ],
            

        ],

        'toolbar'=>[
            '{export}',
            
        ],
        'columns' => [
            
            [
                'label' => 'Actividad',
                'attribute' => 'actividad',
            ],
            [
                'label' => 'Cantidad de Cátedras',
                'attribute' => 'cantidad_catedras',
            ],
            [
                'label' => 'Horas semanales',
                'attribute' => 'horas_semanales',
            ],

            [
                'label' => 'Cantidad Vigente',
                'attribute' => 'cantidad_vigente',
            ],
/*
            [
                'label' => 'Horas pagas',
                'attribute' => 'horas_cobradas',
            ],
*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model['id'] != '' ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['value' => Url::to('index.php?r=reporte/horasmateriaxcatedra/view&id='.$model['id']),
                                'class' => 'modalaReporteHoras btn btn-link']) : '';


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>