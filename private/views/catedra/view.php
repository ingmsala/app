<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */

$this->title = "Catedra";
$this->params['breadcrumbs'][] = ['label' => 'Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
        <?= Html::a('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>'.' Volver', 
        (!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : 'index.php?r=catedra/index'), [
            'class' => 'btn btn-default',
            
        ]) ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['label'=>"Actividad",
            'attribute' =>'actividad0.nombre'],
            ['label'=>"División",
            'attribute' =>'division0.nombre'],
        ],
    ]) ?>


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

    
    <h3>Docentes Nombrados</h3>
    <?= Html::button('Agregar Docente', ['value' => Url::to('index.php?r=detallecatedra/create&catedra='.$model->id), 'class' => 'btn btn-success', 'id'=>'modalButton']) ?>


<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Activo</a></li>
  <li><a data-toggle="tab" href="#menu1">Historial</a></li>
  
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    
    <p>

        <?= GridView::widget([
        'dataProvider' => $dataProvideractivo,
        'rowOptions' => function($model){
            if ($model->condicion0->nombre !='SUPL'){
                return ['class' => 'info'];
            }
            return ['class' => 'warning'];
        },
        'columns' => [
            
            [   
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre'
            ],
            
            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],
            
            [   
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],

            
            [
                'label' => 'Horas',
                'format' => 'raw',
                'value' => function($model){
                    return '<center>'.$model->hora.Progress::widget([
                            'options' => ['class' => 'progress-warning progress-striped'],
                            'percent' => $model->hora*100/$model->catedra0->actividad0->cantHoras,
                            'label' => round($model->hora*100/$model->catedra0->actividad0->cantHoras).'%'.'</center>',
                    ]);
                }
            ],

           // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat} {updatedetcat} {deletedetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=detallecatedra/view&id='.$model->id);
                    },
                    'updatedetcat' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to('index.php?r=detallecatedra/update&id='.$model->id.'&catedra=' .$model->catedra),
                                'class' => 'modala btn btn-link', 'id'=>'modala']);


                    },
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-inbox"></span>', '?r=detallecatedra/inactive&id='.$model->id.'&catedra=' .$model->catedra, 
                            ['data' => [
                            'confirm' => 'Está seguro de querer pasar este elemento al historial?',
                            'method' => 'post',
                             ]
                            ]);
                    },
                ]

            ],
        ],
    ]); ?>

    </p>
  </div>
  <div id="menu1" class="tab-pane fade">
    
    <p>
        
        <?= GridView::widget([
        'dataProvider' => $dataProviderinactivo,
        'rowOptions' => ['class' => 'active'],
        'columns' => [

            [   
                'label' => 'Desde',
                'attribute' => 'fechaInicio'
            ],

            [   
                'label' => 'Hasta',
                'attribute' => 'fechaFin'
            ],
            
            [   
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre'
            ],
            
            [   
                'label' => 'Apellido',
                'attribute' => 'docente0.apellido'
            ],

            [   
                'label' => 'Nombre',
                'attribute' => 'docente0.nombre'
            ],
            
            [   
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],

            
            [
                'label' => 'Horas',
                'format' => 'raw',
                'value' => function($model){
                    return '<center>'.$model->hora.Progress::widget([
                            'options' => ['class' => 'progress-warning progress-striped'],
                            'percent' => $model->hora*100/$model->catedra0->actividad0->cantHoras,
                            'label' => round($model->hora*100/$model->catedra0->actividad0->cantHoras).'%'.'</center>',
                    ]);
                }
            ],

           // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat} {updatedetcat} {deletedetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=detallecatedra/view&id='.$model->id);
                    },
                    'updatedetcat' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to('index.php?r=detallecatedra/update&id='.$model->id.'&catedra=' .$model->catedra),
                                'class' => 'modala btn btn-link', 'id'=>'modala']);


                    },
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=detallecatedra/delete&id='.$model->id, 
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

    </p>
  </div>
  
</div>

    

   

</div>
