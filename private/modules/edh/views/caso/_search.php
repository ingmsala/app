<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\CasoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
        
        $estadoscaso=ArrayHelper::map($estadoscaso,'id','nombre');
        $aniolectivos=ArrayHelper::map($aniolectivos,'id','nombre');
        $listResoluciones=ArrayHelper::map($casos,'resolucion','resolucion');
        $alumnos=ArrayHelper::map($alumnos,'id', function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );
    ?>

<div class="caso-search">


<div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filter = false;
                            if(isset($param['Caso']['aniolectivo'])){
                                if($param['Caso']['aniolectivo']!=''){
                                    $filter = true;
                                    echo '<b> - Año lectivo: </b>'.$aniolectivos[$param['Caso']['aniolectivo']];
                                }
                            }

                            if(isset($param['Caso']['estadocaso'])){
                                if($param['Caso']['estadocaso']!=''){
                                    $filter = true;
                                    echo '<b> - Estado: </b>'.$estadoscaso[$param['Caso']['estadocaso']];
                                    
                                }
                            }

                            if(isset($param['Caso']['resolucion'])){
                                if($param['Caso']['resolucion']!=''){
                                    $filter = true;
                                    echo '<b> - Resolución: </b>'.$param['Caso']['resolucion'];
                                    
                                }
                            }

                            if(isset($param['Caso']['alumno'])){
                                if($param['Caso']['alumno']!=''){
                                    $filter = true;
                                    echo '<b> - Condición: </b>'.$alumnos[$param['Caso']['alumno']];
                                    
                                }
                            }

                            
                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=edh/caso"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
                            $filter = false;
                        }
                    ?>
                   
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">

                <div class="row">
                    
                    <div class="panel-body">

                    <div class="col-md-11">
                        
                    <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                        ]); ?>

                    <?= 

                    $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                        'data' => $aniolectivos,
                        'options' => ['placeholder' => 'Seleccionar...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
                    ]);

                    ?>

                    <?=

                        $form->field($model, 'alumno')->widget(Select2::classname(), [
                            'data' => $alumnos,
                            'options' => ['placeholder' => 'Seleccionar...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                
                            ],
                        ]);


                    ?>

                    <?=

                    $form->field($model, 'estadocaso')->widget(Select2::classname(), [
                        'data' => $estadoscaso,
                        'options' => ['placeholder' => 'Seleccionar...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
                    ]);


                    ?>
                        
                        <?= $form->field($model, 'resolucion')->textInput(['maxlength' => true]) ?>

                        

                        <?php // echo $form->field($model, 'condicionfinal') ?>

                        <?php // echo $form->field($model, 'estadocaso') ?>

                        <div class="form-group">
                            <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
                            
                        </div>

                    <?php ActiveForm::end(); ?>

                    </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    

</div>
