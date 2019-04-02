<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\MatriculaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrículas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matricula-index">

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
                                    echo '<b> - Optativa: </b>'.$listComisiones[$param['Matricula']['comision']];
                                }
                            }

                            

                        ?>

                    </a>
                    <?php
                        if($filter1 || $filter2){
                            echo ' <a href="index.php?r=optativas/matricula/index"><span class="badge badge-danger"><span class="glyphicon glyphicon-remove"></span></span></a>';
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

                                $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
                                    'data' => $listaniolectivos,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Año Lectivo");

                            ?>

                            <?= 

                                $form->field($model, 'comision')->widget(Select2::classname(), [
                                    'data' => $listComisiones,
                                    'options' => ['placeholder' => 'Seleccionar...'],
                                    //'value' => 1,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label("Espacio Optativo");

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],

        'toolbar'=>[
            ['content' => 
                Html::a('Nueva Inscripción', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => function($model){
                    //return var_dump($model);
                    return $model['comision0']['optativa0']['aniolectivo0']['nombre'].' - '.$model['comision0']['optativa0']['actividad0']['nombre'].' - Comisión: '.$model['comision0']['nombre'];
                },
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                
            ],

            [
                'label' => 'Fecha Inscripción',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            'alumno0.dni',
            'alumno0.apellido',
            'alumno0.nombre',
            [
                'label' => 'Estado',
                'attribute' => 'estadomatricula0.nombre',
                
            ],
                        
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
