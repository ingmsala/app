<?php

use app\models\Declaracionjurada;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeclaracionjuradaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Declaraciones Juradas';

?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>Motivo de Rechazo</h2>",
            'id' => 'modalrechazar',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
<div class="declaracionjurada-index">



   <?php 

    $listpersona=ArrayHelper::map($models2,'documento', function($model){
        return $model['apellido'].', '.$model['nombre'];
        });
    $listanio=ArrayHelper::map($ciclolectivo,'id','nombre');
    $listdoc=ArrayHelper::map($models2,'documento','nombre');

    //var_dump($listdoc);
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'method' => 'GET']);
    
    echo $form->field($model, 'persona')->widget(Select2::classname(), [
        'data' => $listpersona,
        'options' => ['placeholder' => 'Seleccionar...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Agente");

    echo $form->field($model, 'fecha')->widget(Select2::classname(), [
        'data' => $listanio,
        'options' => ['placeholder' => 'Seleccionar...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Año de la Declaración Jurada");

    echo Html::submitButton('<span class="glyphicon glyphicon-filter"></span> Filtrar', ['class' => 'btn btn-primary']).' '.Html::a(
        'Restablecer',
        '?r=declaracionjurada/declaracionesjuradasadmin', ['class' => 'btn btn-danger']);
    ActiveForm::end();
    
    echo '<br />';
    echo GridView::widget([
        'dataProvider' => $provider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'hover' => true,
        'responsiveWrap' => false,
        'condensed' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'before' => false,
            'footer' => false,
            'after' => false,
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
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => 'Agente',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                //'attribute' => 'apellido',
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
            ],
            
            [
                'label' => 'Mail',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => 'mail'
                /*'value' => function($model){
                    return var_dump($model);
                }*/
            ],

            [
                'label' => 'Fecha',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                
                'value' => function($model){
                    try {
                        $dj = Declaracionjurada::findOne($model['dj']);
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        return Yii::$app->formatter->asDate($dj->fecha, 'dd/MM/yyyy');
                    } catch (\Throwable $th) {
                        
                    }
                    
                }
            ],

            [
                'label' => 'Declaración jurada',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'attribute' => 'dj',
                'value' => function($model){
                    try {
                        $dj = Declaracionjurada::findOne($model['dj']);
                        
                        if($dj->estadodeclaracion == 1)
                            return '<div class="label label-warning"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pendiente de envío</div>';
                        if($dj->estadodeclaracion == 2)
                            return '<div class="label label-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviada</div>';
                        if($dj->estadodeclaracion == 3)
                            return '<div class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptada</div>';
                        if($dj->estadodeclaracion == 4)
                            return Html::button('<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Rechazada - Debe reenviar', ['value' => Url::to('index.php?r=mensajedj/index&dj='.$dj->id), 'class' => 'btn btn-danger amodalrechazar']);
                            //return '<div class="label label-danger"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Rechazada - Debe reenviar</div>';
                        
                    } catch (\Throwable $th) {
                        return 'Falta';
                    }
                    
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalle} {ver} {imprimir} {rechazar} {aceptar}',
                
                'buttons' => [
                    
                    'detalle' => function($url, $model, $key){
                        //if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                            return Html::a(
                                '<span class="glyphicon glyphicon-plus btn btn-primary"></span>',
                                '?r=declaracionjurada/detalleagente&d='.$model['documento']);
                            
                    },
                    'ver' => function($url, $model, $key){
                        //if($model->estadodeclaracion == 2 || $model->estadodeclaracion == 3)
                            try {
                                $dj = Declaracionjurada::findOne($model['dj']);
                                if($dj->estadodeclaracion == 2 || $dj->estadodeclaracion == 3)
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',
                                    '?r=declaracionjurada/resumen&dj='.$dj['id']);
                            } catch (\Throwable $th) {
                                return '';
                            }
                            
                    },
                    'imprimir' => function($url, $model, $key){
                        try {
                            $dj = Declaracionjurada::findOne($model['dj']);
                            if($dj->estadodeclaracion == 2 || $dj->estadodeclaracion == 3)
                                return Html::a('<span class="glyphicon glyphicon-print btn btn-default"></span>', Url::to('index.php?r=declaracionjurada/print&dj='.$dj['id']));;
                            
                        } catch (\Throwable $th) {
                            return '';
                        }
                    },
                    'rechazar' => function($url, $model, $key){
                        try {
                            $dj = Declaracionjurada::findOne($model['dj']);
                            if($dj->estadodeclaracion == 2)
                            /*return Html::a('<span class="glyphicon glyphicon-ban-circle btn btn-danger"></span>', '?r=declaracionjurada/cambiarestado', 
							['data' => [
							'confirm' => '¿Desea <b>rechazar</b> la declaración jurada?',
							'method' => 'post',
							'params' => [
											'es' => 4,
											'dj' => $dj->id,
										],
							]
                            ]);*/
                            return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => Url::to('index.php?r=mensajedj/create&dj='.$dj->id), 'class' => 'btn btn-danger amodalrechazar']);
                        } catch (\Throwable $th) {
                            return '';
                        }
                        
                        },
                    'aceptar' => function($url, $model, $key){
                        try {
                            $dj = Declaracionjurada::findOne($model['dj']);
                            if($dj->estadodeclaracion == 2)
                                return Html::a('<span class="glyphicon glyphicon-ok-circle btn btn-success"></span>', '?r=declaracionjurada/cambiarestado', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>aceptar</b> la declaración jurada?',
                                'method' => 'post',
                                'params' => [
                                                'es' => 3,
                                                'dj' => $dj->id,
                                            ],
                                ]
                                ]);
                        } catch (\Throwable $th) {
                            return '';
                        }
                        
                        },

                    /*'borrar' => function($url, $model, $key){
                        if($model->estadodeclaracion == 1 || $model->estadodeclaracion == 4)
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=declaracionjurada/delete&id='.$model['dj'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },*/
                ]

            ],
            

            
        ],
    ]);
    
    
    
    ?>
</div>
