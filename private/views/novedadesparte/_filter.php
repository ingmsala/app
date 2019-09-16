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
?>

   
    
<div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filtro = false;
                            if(isset($param['EstadoxnovedadSearch']['finddescrip'])){
                                if($param['EstadoxnovedadSearch']['finddescrip']!=''){
                                    $filtro = true;
                                    echo '<b> - Descripción: </b>'.$param['EstadoxnovedadSearch']['finddescrip'];
                                }
                            }

                            if(isset($param['EstadoxnovedadSearch']['estadonovedad'])){
                                if($param['EstadoxnovedadSearch']['estadonovedad']!=''){
                                    $filtro = true;
                                    echo '<b> - Docente: </b>'.$listestados[$param['EstadoxnovedadSearch']['estadonovedad']];
                                    
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

            <div id="collapseOne" class="panel-collapse collapse">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <?php                 

                                 $form = ActiveForm::begin([
                                    'action' => ['/novedadesparte/panelnovedadesprec'],
                                    'method' => 'get',
                                ]); ?>

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
