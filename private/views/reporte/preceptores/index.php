<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preceptores';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
        
        $listPropuestas=ArrayHelper::map($propuestas,'id','nombre');
        $listRevistas=ArrayHelper::map($revistas,'id','nombre');
        $listCondiciones=ArrayHelper::map($condiciones,'id','nombre');

        
        

    ?>
<div class="revista-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            $filter = false;
                            if(isset($param['Catedra']['propuesta'])){
                                if($param['Catedra']['propuesta']!=''){
                                    $filter = true;
                                    echo '<b> - Propuesta: </b>'.$listPropuestas[$param['Catedra']['propuesta']];
                                }
                            }

                            if(isset($param['Catedra']['docente'])){
                                if($param['Catedra']['docente']!=''){
                                    $filter = true;
                                    echo '<b> - Docente: </b>'.$listDocentes[$param['Catedra']['docente']];
                                    
                                }
                            }

                            if(isset($param['Catedra']['actividadnom'])){
                                if($param['Catedra']['actividadnom']!=''){
                                    $filter = true;
                                    echo '<b> - Actividad: </b>'.$param['Catedra']['actividadnom'];
                                    
                                }
                            }

                            if(isset($param['Catedra']['divisionnom'])){
                                if($param['Catedra']['divisionnom']!=''){
                                    $filter = true;
                                    echo '<b> - Division: </b>'.$param['Catedra']['divisionnom'];
                                    
                                }
                            }


                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=catedra/index"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
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

                                $form->field($model, 'division0')->widget(Select2::classname(), [
                                    'data' => $listPropuestas,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Propuesta Formativa");

                            ?>

                            <?= 

                                $form->field($model, 'revista')->widget(Select2::classname(), [
                                    'data' => $listRevistas,
                                    'options' => [
                                        'placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Revista");

                            ?>

                            <?= 

                                $form->field($model, 'condicion')->widget(Select2::classname(), [
                                    'data' => $listCondiciones,
                                    'options' => [
                                        'placeholder' => 'Seleccionar...',
                                        'multiple' => true,
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Condición");

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


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           

            [
                'label' => 'División',
                'attribute' => 'division0.nombre',
            ],

            [
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido',
            ],

            [
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre',
            ],

            [
                'label' => 'Revista',
                'attribute' => 'revista0.nombre',
            ],

            [
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre', 
            ],

            [
                'label' => 'Suplente',
                'attribute' => 'suplente0.docente0.apellido',
            ],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                
                'buttons' => [
                    
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=nombramiento/update&id='.$model['id']);
                    },

                    
                ]

            ],            
            
            
            
            

            
        ],
    ]); ?>
</div>