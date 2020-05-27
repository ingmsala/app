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

    <?php $listaniolectivo=ArrayHelper::map($aniolectivos,'id', 'nombre');?>
    <?php $listdivisiones=ArrayHelper::map($divisiones,'id', 'nombre');?>


<div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filtro = false;
                            if(isset($param['Inasistencia']['aniolectivo'])){
                                if($param['Inasistencia']['aniolectivo']!=''){
                                    $filtro = true;
                                    echo '<b> - Año Lectivo: </b>'.$listaniolectivo[$param['Inasistencia']['aniolectivo']];
                                }
                            }

                            if(isset($param['Inasistencia']['division'])){
                                if($param['Inasistencia']['division']!=''){
                                    $filtro = true;
                                    echo '<b> - División: </b>'.$listdivisiones[$param['Inasistencia']['division']];
                                    
                                }
                            }

                            


                        ?>

                    </a>
                    <?php
                        if($filtro){
                            echo ' <a href="index.php?r=optativas/reportes/inasistencias"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
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

                                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                                    'data' => $listaniolectivo,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año Lectivo");

                            ?>

                            <?= 
                                
                                $form->field($model, 'division')->widget(Select2::classname(), [
                                    'data' => $listdivisiones,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("División");

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

    
                            

                   