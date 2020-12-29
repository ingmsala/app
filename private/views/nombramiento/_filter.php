<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $listcargos=ArrayHelper::map($cargos,'id', function($car) {
            return '('.$car['id'].') '.$car['nombre'];}
        );?>
    <?php $listdocentes=ArrayHelper::map($docentes,'id', function($doc) {
            return $doc['apellido'].', '.$doc['nombre'];}
        );?>

    <?php $listrevistas=ArrayHelper::map($revistas,'id','nombre'); ?>
    
    <?php $listcondiciones=ArrayHelper::map($condiciones,'id','nombre'); ?>
    
    <?php $listresoluciones=ArrayHelper::map($resoluciones,'resolucion', 'resolucion');?>
    <?php $listresolucionesext=ArrayHelper::map($resolucionesext,'resolucionext', 'resolucionext');?>

<div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filtro = false;
                            if(isset($param['Nombramiento']['cargo'])){
                                if($param['Nombramiento']['cargo']!=''){
                                    $filtro = true;
                                    echo '<b> - Cargo: </b>'.$listcargos[$param['Nombramiento']['cargo']];
                                }
                            }

                            if(isset($param['Nombramiento']['agente'])){
                                if($param['Nombramiento']['agente']!=''){
                                    $filtro = true;
                                    echo '<b> - Agente: </b>'.$listdocentes[$param['Nombramiento']['agente']];
                                    
                                }
                            }

                            if(isset($param['Nombramiento']['revista'])){
                                if($param['Nombramiento']['revista']!=''){
                                    $filtro = true;
                                    echo '<b> - Revista: </b>'.$listrevistas[$param['Nombramiento']['revista']];
                                    
                                }
                            }

                            if(isset($param['Nombramiento']['condicion'])){
                                if($param['Nombramiento']['condicion']!=''){
                                    $filtro = true;
                                    echo '<b> - Condición: </b>'.$listcondiciones[$param['Nombramiento']['condicion']];
                                    
                                }
                            }

                            
                            if(isset($param['Nombramiento']['resolucion'])){
                                if($param['Nombramiento']['resolucion']!=''){
                                    $filtro = true;
                                    echo '<b> - Resolución: </b>'.$param['Nombramiento']['resolucion'];
                                    
                                }
                            }

                            if(isset($param['Nombramiento']['resolucionext'])){
                                if($param['Nombramiento']['resolucionext']!=''){
                                    $filtro = true;
                                    echo '<b> - Resolución de Extensión: </b>'.$param['Nombramiento']['resolucionext'];
                                    
                                }
                            }


                        ?>

                    </a>
                    <?php
                        if($filtro){
                            echo ' <a href="index.php?r=nombramiento/index"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filtro = false;
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

                                $form->field($model, 'cargo')->widget(Select2::classname(), [
                                    'data' => $listcargos,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Cargo");

                            ?>

                            <?= 
                                
                                $form->field($model, 'agente')->widget(Select2::classname(), [
                                    'data' => $listdocentes,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Agente");

                            ?>

                            <?= 
                                
                                $form->field($model, 'revista')->widget(Select2::classname(), [
                                    'data' => $listrevistas,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Revista");

                            ?>

                            <?= 
                                
                                $form->field($model, 'condicion')->widget(Select2::classname(), [
                                    'data' => $listcondiciones,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Condición");

                            ?>

                                                  
                            
                            <?= 
                                
                                $form->field($model, 'resolucion')->widget(Select2::classname(), [
                                    'data' => $listresoluciones,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Resolución");

                            ?>

                            <?= 
                                
                                $form->field($model, 'resolucionext')->widget(Select2::classname(), [
                                    'data' => $listresolucionesext,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Resolución de Extensión");

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
