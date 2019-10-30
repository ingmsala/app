<?php

use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ActaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acta-index">

    <?php
        $listaniolectivos=ArrayHelper::map($aniolectivos,'id','nombre');
        $listComisiones=ArrayHelper::map($comisiones,'comision', function($comision) {
          return $comision['comision0']['optativa0']['aniolectivo0']['nombre'].' - '.$comision['comision0']['optativa0']['actividad0']['nombre'].' ('.$comision['comision0']['nombre'].')';}
        );
        
    ?>
    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>
                        <?= ($collapse=='in') ? '&nbsp&nbsp <b>Actas</b>' : '' ?>
                        <?php 
                            $filter1 = false;
                            if(isset($param['Matricula']['aniolectivo'])){
                                if($param['Matricula']['aniolectivo']!=''){
                                    $filter1 = true;
                                    echo '<b> - Año Lectivo: </b>'.$listaniolectivos[$param['Matricula']['aniolectivo']];
                                }
                            }

                            

                        ?>

                        <?php 
                            $filter2 = false;
                            if(isset($param['Matricula']['comision'])){
                                if($param['Matricula']['comision']!=''){
                                    $filter2 = true;
                                    try {
                                        echo '<b> - Optativa: </b>'.$listComisiones[$param['Matricula']['comision']];
                                    } catch (Exception $e) {
                                        echo '<b> - Optativa: Sin Matriculados</b>';
                                    }
                                    
                                }
                            }

                            

                        ?>

                    </a>
                    <?php
                        if($filter1 || $filter2){
                            echo ' <a href="index.php?r=optativas/acta/index"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class=<?='"panel-collapse collapse '.$collapse.'"' ?>>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['index'],
                                    'method' => 'post',
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

                            <?= 

                                $form->field($model, 'comision')->widget(DepDrop::classname(), [
                                    //'data' => $listComisiones,
                                    'options'=>['id'=>'comision-id'],
                                    //'value' => 1,
                                    'pluginOptions'=>[
                                        'depends'=>['anio-id'],
                                        'placeholder'=>'(Todos)',
                                        'url'=>Url::to(['/optativas/comision/comxanio'])
                                    ]
                                ])->label("Espacio Optativo");

                            ?>

                            <div class="form-group">
                                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                                
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    

    <?php
    if($collapse==""){

        $form2 = ActiveForm::begin([
                                    'action' => ['create'],
                                    'method' => 'get',
                ]);
        
        echo $form2->field($model, 'aniolectivo')->hiddenInput()->label(false);
        echo $form2->field($model, 'comision')->hiddenInput()->label(false);

        echo Html::submitButton('Nueva Acta', ['class' => 'btn btn-success']);
                                
      
        ActiveForm::end();
        
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            

            [
                'label' => 'Libro',
                'value' => function($model){
                    return $model->libro0->nombre;
                }
            ],
            
            [
                'label' => 'Acta',
                'value' => function($model){
                    return $model->nombre;
                }
            ],
            

            [
                'label' => 'Actividad',
                'value' => function($model){
                    return $model->comision0->optativa0->actividad0->nombre;
                }
            ],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            

            [
                'label' => 'Rectifica',
                'value' => function($model){
                    if ($model->rectifica == null)
                        return 'No';
                    return $model->rectifica;
                }
            ],

            [
                    'class' => 'kartik\grid\BooleanColumn',
                    //'attribute' => 'estadoacta0', 
                    'hiddenFromExport' => true,
                    'label' => 'Estado',
                    'vAlign' => 'middle',
                    'trueIcon' => '<span class="glyphicon glyphicon-record text-success"></span>',
                    'falseIcon' => '<span class="glyphicon glyphicon-record text-danger"></span>',
                    'value' => function ($model){
                        if($model->estadoacta == 1)
                            return true;
                        return false;
                        
                    }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    }

    ?>
</div>
