<?php

use app\config\Globales;
use app\modules\curriculares\models\Alumno;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\becas\models\BecasolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitud de beca';
$divisiones = ArrayHelper::map($divisiones, 'id', 'nombre');
?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="becasolicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php                 

            $form = ActiveForm::begin([
            'method' => 'post',
        ]); ?>

    <?= 

        $form->field($model, 'divisiones')->widget(Select2::classname(), [
            'data' => $divisiones,
            'options' => ['placeholder' => 'Seleccionar...', 'id' => 'anio-id'],
            //'value' => 1,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Todos', ['index', 'convocatoria' => $convocatoria], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

   <?=
    Html::a('<span class="glyphicon glyphicon-refresh"></span> Recalcular todas', '?r=becas/becasolicitud/recalculartodas', 
    [
        'class' => 'btn btn-primary pull-right',
        'data' => [
    
    'confirm' => '¿Desea <b>recalcular todos</b> los puntaje de la convocatoria?',
    'method' => 'post',
    'params' => [
                    'conv' => 1,
                ],
    ]
    ]);
   ?>
   <div class="clearfix"></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' => 'Fecha',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'División',
                'value' => function($model){
                    $alumno = $model->estudiante0->alumno0;
                    $alumno2 = new Alumno();
                    $alumno2 = $alumno;
                    try {
                        $divi = $alumno2->matriculaactual($model->convocatoria0->aniolectivo)->division0->nombre;
                        return $divi;
                    } catch (\Throwable $th) {
                        return 'Sin división';
                    }
                    
                }
            ],
            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->estudiante0->apellido.', '.$model->estudiante0->nombre;
                }
            ],
            [
                'label' => 'Solicitante',
                'value' => function($model){
                    return $model->solicitante0->apellido.', '.$model->solicitante0->nombre;
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return $model->estado0->nombre;
                }
            ],
            [
                'label' => 'Puntaje',
                'format' => 'raw',
                'value' => function($model){
                    return  Html::button($model->puntaje, ['value' => Url::to(['/becas/becasolicitud/obtenerpuntaje', 'sol' => $model->id]), 'title' => 'Detalle de Puntaje', 'class' => 'btn btn-link amodalgenerico']);
                    
                }
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {imprimir} {recalcular} {reenviar} {verpuntaje}',
                
                'buttons' => [
                    
                    
                    'ver' => function($url, $model, $key){
                            return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',
                                    '?r=becas/default/resumen&s='.$model->token);
                            
                            
                    },
                    'imprimir' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-print btn btn-default"></span>',
                            '?r=becas/default/print&s='.$model->token);
                    },
                    'rechazar' => function($url, $model, $key){
                            if($model->estado == 2)
                                 return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => Url::to('index.php?r=becas/default/rechazar&s='.$model->id), 'class' => 'btn btn-danger amodalrechazar']);
                        },
                    'aceptar' => function($url, $model, $key){
                            if($model->estado == 2)
                                return Html::a('<span class="glyphicon glyphicon-ok-circle btn btn-success"></span>', '?r=becas/default/aceptar', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>aceptar</b> la declaración jurada?',
                                'method' => 'post',
                                'params' => [
                                                's' => 3,
                                                'dj' => $model->id,
                                            ],
                                ]
                                ]);
                        
                        },

                    'recalcular' => function($url, $model, $key){

                                return Html::a('<span class="glyphicon glyphicon-refresh btn btn-primary"></span>', '?r=becas/becasolicitud/recalcular', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>recalcular</b> el puntaje de la solicitud?',
                                'method' => 'post',
                                'params' => [
                                                'sol' => $model->id,
                                            ],
                                ]
                                ]);
                        
                        },

                    'reenviar' => function($url, $model, $key){
                            //if($model->estado < 3 )
                                return Html::a('<span class="glyphicon glyphicon-send btn btn-warning"></span>', '?r=becas/becasolicitud/reenviar', 
                                ['data' => [
                                
                                'confirm' => '¿Desea <b>enviar</b> un correo al solicitante '.$model->solicitante0->apellido.', '.$model->solicitante0->nombre.' ('.$model->solicitante0->mail.') habilitando la modificación de la solicitud?<br>
                                Link de la solictitud:<br/>'.Html::a('http://admin.cnm.unc.edu.ar/front/index.php?r=becas%2Fdefault%2Fsolicitud&s='.$model->token, Url::to(['/becas/default/solicitud', 's' => $model->token], true)),
                                'method' => 'post',
                                'params' => [
                                                'sol' => $model->id,
                                            ],
                                ]
                                ]);
                        
                        },

                    'verpuntaje' => function($url, $model, $key){
                        //if($model->estado == 2)
                            return  Html::button('<span class="glyphicon glyphicon-zoom-in"></span>', ['value' => Url::to(['/becas/becasolicitud/obtenerpuntaje', 'sol' => $model->id]), 'title' => 'Detalle de Puntaje (sin calcular)', 'class' => 'btn btn-success amodalgenerico']);
                    },
                ]

            ],
        ],
    ]); ?>
</div>
