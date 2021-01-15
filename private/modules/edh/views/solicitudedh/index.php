<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\SolicitudedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;
$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'solicitudes',
];
?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Agregar solicitud al  Caso #'.$model->id."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="solicitudedh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar solicitud', ['value' => Url::to('index.php?r=edh/solicitudedh/create&id='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado']); ?>
    </p>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],

            [
                'label' => 'Área de Recepción',
                'value' => function($model){
                    return $model->areasolicitud0->nombre;
                }
            ],
            
            [
                'label' => 'Demandante',
                'value' => function($model){
                    if($model->demandante !=null)
                        return $model->demandante0->apellido.', '.$model->demandante0->nombre.' ('.$model->demandante0->parentesco.')';
                    return '';
                }
            ],

            [
                'label' => 'Estado',
                'value' => function($model){
                    return $model->estadosolicitud0->nombre;
                }
            ],

            [
                'label' => 'Tipo',
                'value' => function($model){
                    return $model->tiposolicitud0->nombre;
                }
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {rechazar} {eliminar}',
                
                'buttons' => [
                    
                    'ver' => function($url, $model, $key){
                        //if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                            return Html::a(
                                '<span class="glyphicon glyphicon-plus btn btn-primary"></span>',
                                '?r=edh/solicitudedh/view&id='.$model['id']);
                            
                    },
                                       
                    'rechazar' => function($url, $model, $key){
                        
                            return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => Url::to('index.php?r=edh/create&dj='.$model->id), 'class' => 'btn btn-danger amodalrechazar']);
                       
                        
                        },
                    'eliminar' => function($url, $model, $key){
                        
                                return Html::a('<span class="glyphicon glyphicon-ok-circle btn btn-success"></span>', '?r=edh/cambiarestado', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>aceptar</b> la declaración jurada?',
                                'method' => 'post',
                                'params' => [
                                                'es' => 3,
                                                'dj' => $model->id,
                                            ],
                                ]
                                ]);
                        
                        
                        },

                    
                ]

            ],
        ],
    ]); ?>
</div>
