<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
/* @var $form yii\widgets\ActiveForm */
$listestados=ArrayHelper::map($estados,'id','nombre');
$listtrimestrales=ArrayHelper::map($trimestrales,'id','nombre');
$listanioslectivos=ArrayHelper::map($aniolectivo,'id','nombre');
?>

  
    
<div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>
                        <?= ($collapse=='in') ? '&nbsp&nbsp <b>Alumnos ausentes a Exámenes trimestrales</b>' : '' ?>
                        <?php 
                            $filtro = false;
                            if(isset($param['Estadoxnovedad']['aniolectivo'])){
                                if($param['Estadoxnovedad']['aniolectivo']!=''){
                                    $filtro = true;
                                    echo '<b> - Año lectivo: </b>'.$listanioslectivos[$param['Estadoxnovedad']['aniolectivo']];
                                }
                            }

                            if(isset($param['Estadoxnovedad']['trimestral'])){
                                if($param['Estadoxnovedad']['trimestral']!=''){
                                    $filtro = true;
                                    echo '<b> - Instancia: </b>'.$listtrimestrales[$param['Estadoxnovedad']['trimestral']];
                                }
                            }

                            if(isset($param['Estadoxnovedad']['finddescrip'])){
                                if($param['Estadoxnovedad']['finddescrip']!=''){
                                    $filtro = true;
                                    echo '<b> - Descripción: </b>'.$param['Estadoxnovedad']['finddescrip'];
                                }
                            }

                            if(isset($param['Estadoxnovedad']['estadonovedad'])){
                                if($param['Estadoxnovedad']['estadonovedad']!=''){
                                    $filtro = true;
                                    echo '<b> - Docente: </b>'.$listestados[$param['Estadoxnovedad']['estadonovedad']];
                                    
                                }
                            }

                            
                        ?>

                    </a>
                    <?php
                        if($filtro){
                            echo ' <a href="index.php?r=novedadesparte/panelnovedadesprec"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filtro = false;
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
                                    'action' => ['/novedadesparte/panelnovedadesprec'],
                                    'method' => 'post',
                                ]); ?>

                            <?= 
                                
                                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                                    'data' => $listanioslectivos,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año lectivo");

                            ?>

                            <?= 
                                
                                $form->field($model, 'trimestral')->widget(Select2::classname(), [
                                    'data' => $listtrimestrales,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Trimestral");

                            ?>

                            <?= 

                                $form->field($model, 'finddescrip')->textInput(['maxlength' => true])->label("Descripción (alumno o curso)");

                            ?>

                            <?= 
                                
                                $form->field($model, 'estadonovedad')->widget(Select2::classname(), [
                                    'data' => $listestados,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Estado");

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
