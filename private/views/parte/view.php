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
    <!--
    <div class="alert alert-info fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Nuevo!</strong> Existen dos pestañas en el parte. En la primera <strong>Asistencia Docente</strong> para la carga de Asistencia de los profesores como se venía haciendo (La ausencia de preceptores no se debe marcar como hora cero). En la segunda de <strong>Novedades</strong>, para cargar la inasistencia de los Preceptores y otras opciones como: <ul>
            <li>problemas edilicios</li>
            <li>problemas en cañones y equipos de audio</li>
            <li>nuevos docentes que se hacen cargo de una materia</li>
        </ul>

        En la descripción de la novedad, si corresponde, especificar número de aula y bancos en caso de que haya que efectuar reparaciones.
    </div>-->


    <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#parte">Asistencia Docente</a></li>
          <li><a data-toggle="tab" href="#novedades">Novedades</a></li>
          <li><a data-toggle="tab" href="#aviso">Aviso de Inasistencias <span class="badge"> <?=$dataProvideravisosinasistencias->getTotalCount()?></span></a></li>
          
        </ul>

        <div class="tab-content">
            <div id="parte" class="tab-pane fade in active">
            
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
                                        'label' => 'Docente',
                                        //'attribute' => 'docente0.apellido',
                                        'value' => function($model){
                                            return $model->docente0->apellido.', '.$model->docente0->nombre;
                                        }
                                    ],


                                    
                                    [   
                                        'label' => 'Tipo de Falta',
                                        'attribute' => 'falta0.nombre'
                                    ],

                                    

                                    [
                                        'label' => 'Detalle',
                                        'attribute' => 'detalleadelrecup',
                                        'format' => 'raw',
                                        'value' => function($model){
                                            $txt = '';
                                            if($model->llego != null)
                                                $txt .='<span class="label label-primary">Llegó</span> '.$model->llego.' min. tarde<br />';
                                            if($model->retiro != null)
                                                $txt .='Se <span class="label label-primary">retiró</span> '.$model->retiro.' min. antes<br />';
                                            if($model->detalleadelrecup != null && $model->falta==6)
                                                $txt .='<span class="label label-primary">Detalle</span> recupero: '.$model->detalleadelrecup.'<br />';
                                            if($model->detalleadelrecup != null && $model->falta==7)
                                                $txt .='<span class="label label-primary">Detalle</span> adelanto: '.$model->detalleadelrecup.'<br />';
                                            return $txt;
                                        }
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
                                                if($model->estadoinasistencia == 1 or in_array (Yii::$app->user->identity->role, [1]))
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
          <div id="novedades" class="tab-pane fade">
            <?php 

                echo $this->render('/novedadesparte/index',[

                    'searchModel' => $searchModelnovedades,
                    'dataProvider' => $dataProvidernovedades,

                    'searchModelnovedadesEdilicias' => $searchModelnovedadesEdilicias,
                    'dataProvidernovedadesEdilicias' => $dataProvidernovedadesEdilicias,
                    
                    'model' => $model,

                ]) 

            ?>
            

          </div>

          <div id="aviso" class="tab-pane fade">
            <?php 

                echo $this->render('/avisoinasistencia/index',[

                    'searchModel' => $searchModelavisosinasistencias,
                    'dataProvider' => $dataProvideravisosinasistencias,
                    'model' => $model,

                ]) 

            ?>
            

          </div>
          
        </div>







    

    
</div>
