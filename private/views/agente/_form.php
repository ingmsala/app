<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Agente */
/* @var $form yii\widgets\ActiveForm */
?>



<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo '<div id="modalContent"><div class="alert alert-warning" role="alert">
            Solo se deberá cargar un nuevo docente si se consignará el <b>correo institucional definitivo</b>, ya que con el mismo se genera el usuario de acceso al sistema. <br/><br/>Si no cuenta con el correo UNC del docente, por favor no proceder con esta acción.
        </div></div>';

        Modal::end();
    ?>

<div class="agente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listgeneros=ArrayHelper::map($generos,'id','nombre'); ?>
    <?php $listtipodocumento=ArrayHelper::map($tipodocumento,'id','nombre'); ?>
    <?php $tipocargo=ArrayHelper::map($tipocargo,'id','nombre'); ?>
    
    <?= $form->field($model, 'tipodocumento')->dropDownList($listtipodocumento, ['prompt'=>'Seleccionar...']); ?>

    <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'legajo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'text-transform:uppercase;']) ?>

    <?= $form->field($model, 'genero')->dropDownList($listgeneros, ['prompt'=>'Seleccionar...']); ?>
    
    <?php
        if($origen == 'create'){
            echo $form->field($model, 'tiposcargo')->widget(Select2::classname(), [
                'data' => $tipocargo,
                'options' => ['placeholder' => 'Seleccionar...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]);
        }else{
            echo '<div class="panel panel-default"><div class="panel-body">';
            echo '<label>Tipo de cargo</label>'.Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar tipo', ['value' => Url::to('index.php?r=agentextipo/create&agente='.$model->id), 'class' => 'btn btn-link pull-right', 'id'=>'modalaDetalleParte']);
            echo '<div class="clearfix"></div>';
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
        
                   'tipocargo0.nombre',
        
                   [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{borrar}',
                    //'visible' => (in_array (Yii::$app->user->identity->role, [1])) ? true : false,
                    'buttons' => [
                        'borrar' => function($url, $model, $key){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=agentextipo/delete&id='.$model->id, 
                                [
                                    'data' => [
                                
                                        'confirm' => '¿Desea <b>eliminar</b> el elemento?',
                                        'method' => 'post',
                                        
                                    ]
                                ]);
                        },

                                                
                    ]
    
                ],
                ],
            ]);
            echo '</div></div>';
        }
        
    ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true, 'style'=>'text-transform:lowercase;']) ?>

    <?= 
        $form->field($model, 'fechanac')->widget(DatePicker::classname(), [
            //'name' => 'dp_3',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //'value' => '23-Feb-1982',
            'readonly' => true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                
                
            ],
    
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success', 'id'=>'modala']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
