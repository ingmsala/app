<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;




?>

    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            
                            //var_dump($param);
                            if(count($param)>1)
                                $colapse = 'collapse';
                            else    
                                $colapse = '';
                            
                            $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',]; 

                            //$years = [ 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023'];
                            $years=ArrayHelper::map($years,'nombre','nombre');
                            $listDocentes=ArrayHelper::map($docentes,'id', function($doc) {
                                    return $doc['apellido'].', '.$doc['nombre'];}
                            );

                            $listEstadoinasistencia=ArrayHelper::map($estadoinasistencia,'id','nombre');

                            $filter = false;
                            
                            if(isset($param['Detalleparte']['anio'])){
                                if($param['Detalleparte']['anio']!=''){
                                    $filter = true;
                                    echo '<b> - Año: </b>'.$years[$param['Detalleparte']['anio']];
                                }
                            }

                            if(isset($param['Detalleparte']['mes'])){
                                if($param['Detalleparte']['mes']!=''){
                                    $filter = true;
                                    echo '<b> - Mes: </b>'.$meses[$param['Detalleparte']['mes']];
                                    
                                }
                            }

                            if(isset($param['Detalleparte']['agente'])){
                                if($param['Detalleparte']['agente']!=''){
                                    $filter = true;
                                    echo '<b> - Agente: </b>'.$listDocentes[$param['Detalleparte']['agente']];
                                    
                                }
                            }

                            if(isset($param['Detalleparte']['estadoinasistencia'])){
                                if($param['Detalleparte']['estadoinasistencia']!=''){
                                    $filter = true;
                                    echo '<b> - Estado: </b>'.$listEstadoinasistencia[$param['Detalleparte']['estadoinasistencia']];
                                    
                                }
                            }

                            if(isset($param['Detalleparte']['solodia'])){
                                if($param['Detalleparte']['solodia']==1){
                                    $filter = true;
                                    echo '<b> - Por día </b>';
                                    
                                }
                            }

                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=parte/'.$origen.'"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse <?=$colapse?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => [$origen],
                                    'method' => 'get',
                                ]); ?>

                            <?= 

                                $form->field($model, 'anio')->widget(Select2::classname(), [
                                    'data' => $years,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año");

                            ?>

                            <?= 
                                
                                $form->field($model, 'mes')->widget(Select2::classname(), [
                                    'data' => $meses,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Mes");

                            ?>

                            <?= $form->field($model, 'agente')->widget(Select2::classname(), [
                                    'data' => $listDocentes,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Agente");

                            ?>

                            <?= $form->field($model, 'estadoinasistencia')->widget(Select2::classname(), [
                                    'data' => $listEstadoinasistencia,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Estado");

                            ?>

                            <?= $form->field($model, 'solodia')->checkbox(['label'=>''])->label('Por día'); ?>
                        
                            
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