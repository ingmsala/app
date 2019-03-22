<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;



/* @var $this yii\web\View */
/* @var $searchModel app\models\ParteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente';
$this->params['breadcrumbs'][] = $this->title;
$precepx = Yii::$app->user->identity->username;

/*RULES VIEW*/
if(in_array (Yii::$app->user->identity->role, [1]))
        $template =  "{viewdetcat} {updatedetcat} {deletedetcat}";
    else
        $template =  "{viewdetcat}";

?>
<div class="parte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>


        <div id="accordion" class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <span class="badge badge-light"><span class="glyphicon glyphicon-filter"></span> Filtros</span>

                        <?php 
                            
                            //var_dump($param);
                            
                            $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',]; 

                            $years = [ 2018 => '2018', 2019 => '2019', 2020 => '2020', 2021 => '2021', 2022 => '2022', 2023 => '2023'];

                            $listPreceptorias=ArrayHelper::map($preceptorias,'id','nombre');

                            $filter = false;
                            
                            if(isset($param['Parte']['fecha'])){
                                if($param['Parte']['fecha']!=''){
                                    $filter = true;
                                    echo '<b> - Año: </b>'.$years[$param['Parte']['fecha']];
                                }
                            }

                            if(isset($param['Parte']['mes'])){
                                if($param['Parte']['mes']!=''){
                                    $filter = true;
                                    echo '<b> - Mes: </b>'.$meses[$param['Parte']['mes']];
                                    
                                }
                            }

                            if(isset($param['Parte']['preceptoria'])){
                                if($param['Parte']['preceptoria']!=''){
                                    $filter = true;
                                    echo '<b> - Preceptoría: </b>'.$listPreceptorias[$param['Parte']['preceptoria']];
                                    
                                }
                            }

                        ?>

                    </a>
                    <?php
                        if($filter){
                            echo ' <a href="index.php?r=parte/index&nofilter"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
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

                                $form->field($model, 'fecha')->widget(Select2::classname(), [
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

                            <?= $form->field($model, 'preceptoria')->widget(Select2::classname(), [
                                    'data' => $listPreceptorias,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Preceptoría");

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

        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Parte Docente', Url::to('index.php?r=parte/create'), ['class' => 'btn btn-success']) //'id'=>'nuevoparte' ?>
        
        
    </p>

    <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

    <?php


                           
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            
            if ($model['fecha'] == date('Y-m-d')){
                return ['class' => 'info', 'style'=>"font-weight:bold"];
            }
            return ['class' => 'warning'];
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd-MM-yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd-MM-yyyy');
                }
            ],
            [   
                'label' => 'Preceptoria',
                'attribute' => 'preceptoria',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $template,
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=parte/view&id='.$model['id']);
                    },
                    'updatedetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=parte/update&id='.$model['id']);
                    },

                        
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=parte/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },
                ]

            ],
        ],
    ]); ?>
</div>
