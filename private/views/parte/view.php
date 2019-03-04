<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Parte */
$formatter = \Yii::$app->formatter;

$this->title = $model->preceptoria0->nombre .' - '.$formatter->asDate($model->fecha, 'dd/MM/yyyy');
$this->params['breadcrumbs'][] = ['label' => 'Partes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parte-view">

    <h1><?= Html::encode($this->title) ?></h1>

       

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
    <div class="row">
          <div class="col-md-9">
                 <h3>Ausencia de Docentes</h3>
                <?= Html::button('Agregar Ausencia', ['value' => Url::to('index.php?r=detalleparte/create&parte='.$model->id.'&preceptoria='.$model->preceptoria), 'class' => 'btn btn-success', 'id'=>'modalaDetalleParte']) ?>
                
                <?= 

               GridView::widget([
                    
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function($model){

                        if ($model->falta !=1){
                            return ['class' => 'info'];
                        }
                        return ['class' => 'warning'];
                    },
                    'columns' => [
                        
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

                        [
                            'label' => 'Estado',
                            'attribute' => 'estadoinasistencia0.nombre'
                        ],
                        
                       

                       // ['class' => 'yii\grid\ActionColumn'],
                        [
                            'class' => 'yii\grid\ActionColumn',

                            'template' => '{updatedetcat} {deletedetcat}',
                            
                            'buttons' => [
                                
                                'updatedetcat' => function($url, $model, $key){
                                    if($model->estadoinasistencia ==1)
                                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['value' => Url::to('index.php?r=detalleparte/update&id='.$model->id.'&parte=' .$model->parte),
                                            'class' => 'modala btn btn-link', 'id'=>'modala']);


                                },
                                'deletedetcat' => function($url, $model, $key){
                                    if($model->estadoinasistencia ==1)
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=detalleparte/delete&id='.$model->id, 
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
        <div class="col-md-3">
            <?= $this->render('/detalleparte/otrasausencias', [
                
                'dataProviderOtras' => $dataProviderOtras,
                'searchModel' => $searchModel,
                
            ]) ?>
        </div>
    </div>
    
</div>
