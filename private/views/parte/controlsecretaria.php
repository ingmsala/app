<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente - Control Secretaría';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleparte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [

           [   
                'label' => 'Fecha',
                'attribute' => 'parte0.fecha',
                'value' => function($model){
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                }
            ],

            [   
                'label' => 'Division',
                'attribute' => 'division0.nombre'
            ],

            [   
                'label' => 'Hora',
                'attribute' => 'hora0.nombre'
            ],

            
            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],

            'llego', 
            'retiro',
            [   
                'label' => 'Tipo de Falta',
                'attribute' => 'falta0.nombre'
            ],
            /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg}',
                
                'buttons' => [
                    'savereg' => function($url, $model, $key){

                        //return Html::a('<span class=" modalRegencia glyphicon glyphicon-plus"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        return Html::a('Justificar',false,['class' => 'btn btn-warning']);
                        return $model->id != '' ? Html::button('Justificar', ['value' => Url::to('index.php?r=estadoinasistenciaxparte/justificar&detalleparte='.$model->id.'&estadoinasistencia=4'), 'class' => 'modalSecretaria btn btn-warning',  ]) : '';
                    },
                    
                ]

            ],*/
/*
             [   
                
                'label' => 'Control Regencia',
                'format' => 'raw',
                'attribute' => 'falta0.nombre',
                'value' => function($model)
                {
                    var_dump($model->falta);
                    return Select2::widget([
                        'model' => $model,
                        'attribute' => 'falta',
                        'data' => [ 1 =>'Ratificar', 2 =>'Comisión', 
                                    
                                   ],
                        'hideSearch' => true,
                        'options' => [
                                        'id' => 'falta'.$model->id,
                                        'name' => 'falta'.$model->id,
                                     ],
                        'pluginOptions' => [
                                 'allowClear' => false,
                        ],
                    ]);
                },
            ],
*/
            [   
                'label' => 'Estados',
                'attribute' => 'estadoinasistenciaxpartes.nombre',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model){
                    $items = [];
                    $itemsc = [];

                                        
                    foreach($model->estadoinasistenciaxpartes as $estadoinasistenciaxparte){
                         $itemsc[] = [$estadoinasistenciaxparte->fecha, $estadoinasistenciaxparte->estadoinasistencia0->nombre, $estadoinasistenciaxparte->falta0->nombre];
                        
                    }

                    sort($itemsc);

                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                        //$formatter = \Yii::$app->formatter;
                            return 
                                //Html::tag('li', Html::tag('div', Html::tag('span', $formatter->asDate($item[0], "dd/MM/yyyy - HH:i"), ['class' => "badge pull-right"])."&nbsp;".$item[1], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                            Html::tag('li', Html::tag('div', Html::tag('span', $item[2], ['class' => "badge pull-right"])."&nbsp;".$item[1], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                            }
                            
                    , 'class' => "nav nav-pills nav-stacked"]);


                    //return var_dump($model->estadoinasistenciaxpartes);
               }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savereg}',
                
                'buttons' => [
                    'savereg' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        //return Html::a('<span class="glyphicon glyphicon-ok"></span>',false,['class' => 'btn btn-success']);
                         return Html::a('Justificar', '?r=estadoinasistenciaxparte/nuevoestado&detalleparte='.$model->id.'&estadoinasistencia=4', ['class' => 'btn btn-warning',
                            'data' => [
                            'confirm' => 'Está seguro de querer justificar la inasistencia del docente?',
                            'method' => 'post',
                             ]
                            
                     ]);

                         
                    },
                    
                ]

            ],
        ],
    ]); ?>
</div>
