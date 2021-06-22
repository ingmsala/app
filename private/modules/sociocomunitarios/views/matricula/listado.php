<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas - Proyectos Sociocomunitarios';
$this->params['breadcrumbs'][] = $this->title;
$anio = $model->aniolectivo;
?>
<div class="matricula-index">

    <?php
        $listaniolectivos=ArrayHelper::map($aniolectivos,'id','nombre');
        
    ?>
    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filter1 = false;
                            if(isset($param['Matricula']['aniolectivo'])){
                                if($param['Matricula']['aniolectivo']!=''){
                                    $filter1 = true;
                                    echo '<b> - Año Lectivo: </b>'.$listaniolectivos[$param['Matricula']['aniolectivo']];
                                }
                            }

                            

                        ?>

                        

                    </a>
                    <?php
                        if($filter1){
                            echo ' <a href="index.php?r=optativas/matricula/listado"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['listado'],
                                    'method' => 'get',
                                ]); ?>

                            <?= 

                                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                                    'data' => $listaniolectivos,
                                    'options' => ['placeholder' => 'Seleccionar...', 'id' => 'anio-id'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año Lectivo");

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
            GridView::EXCEL => [
                'label' => 'Excel', 
                'filename' =>Html::encode($this->title),
                'config' => [
                    'worksheet' => Html::encode($this->title),
            
                ]
            ],
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

        'toolbar'=>[
            ['content' => 
               ''

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['espaciocurricular0']['aniolectivo0']['nombre'].' - '.$model['comision0']['espaciocurricular0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'].' ('.$model['comision0']['espaciocurricular0']['curso'].'° año)';
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],
            [
                'label' => 'División',
                
                'value' => function($model) use($anio){
                    //return var_dump($model);
                    $mat = null;
                    foreach ($model->alumno0->matriculasecundarios as $value) {
                        if($value->aniolectivo == $anio){
                            $mat = $value;
                            break;
                        }
                    }
                    if($mat==null){
                        return 'Sin división';
                    }
                    return $mat->division0->nombre;
                },
                
            ],

            
            'alumno0.documento',
            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => 'Condición',
                'attribute' => 'estadomatricula0.nombre',
                
            ],
            [
                'label' => 'Correo electrónico',
                'attribute' => 'alumno0.mail',
                
            ],
            
            
                        
            

            
        ],
    ]); ?>
</div>
