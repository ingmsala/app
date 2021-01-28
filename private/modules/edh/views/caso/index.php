<?php

use app\modules\edh\models\Caso;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CasoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Casos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalplancursado',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<div class="caso-index">


    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode($this->title),
            'footer' => false,
            'after' => false,
            'before' => $this->render('_search', [
                'param' => $param,
                'model' => $model,
                'alumnos' => $alumnos,
                'estadoscaso' => $estadoscaso,
                'casos' => $casos,
                'aniolectivos' => $aniolectivos,
            ]).Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Nueva solicitud', ['value' => Url::to(['create']), 'title' => 'Nueva solicitud',  'class' => 'btn btn-success amodalplancursado pull-right'])
            
            //'beforeOptions' => ['style'=>'width:80%;'],
        ],
        'toolbar'=>[
            
            //'{export}',
            
        ],
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Año lectivo',
                'format' => 'raw',
                'value' => function($model){
                    
                    return Html::a($model['aniolectivo'], Url::to(['view', 'id' => $model['id']]));
                }
            ],
            [
                'label' => 'Fecha de solicitud',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    
                    return Html::a(Yii::$app->formatter->asDate($model['inicio'], 'dd/MM/yyyy'), Url::to(['view', 'id' => $model['id']]));
                }
            ],
            [
                'label' => 'Fecha de cierre',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    
                    return Html::a(Yii::$app->formatter->asDate($model['fin'], 'dd/MM/yyyy'), Url::to(['view', 'id' => $model['id']]));
                }
            ],
           
            [
                'label' => 'N° Resolución',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model['resolucion'], Url::to(['view', 'id' => $model['id']]));
                }
            ],
            
            [
                'label' => 'Estudiante',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model['alumno'], Url::to(['view', 'id' => $model['id']]));
                }
            ],
            [
                'label' => 'Condición final',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model['condicionfinal'], Url::to(['view', 'id' => $model['id']]));
                    
                }
            ],
            [
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function($model){
                    $caso = Caso::findOne($model['id']);
                    //return var_dump($caso->vencido);
                    if($model['estadocaso'] == 'Cerrado')
                            return '<span class="label label-default">Cerrado</span>';
                    
                    
                    $vencido = $caso->vencido;
                    if($vencido[0]){
                        return '<span class="label label-success">Abierto</span> <span class="label label-danger">Certificado vencido</span>';
                    }else{
                            //date_default_timezone_set('America/Argentina/Buenos_Aires');
                            //$interval = date_diff(date_create(date('Y-m-d')), date_create($caso->vencido[1]));
                            if($vencido[1]>7)
                                return '<span class="label label-success">Abierto</span>';
                            elseif($vencido[1]==1)
                                return '<span class="label label-success">Abierto</span> <span class="label label-warning">Certificado vence en '.$vencido[1].' día</span>';
                            elseif($vencido[1]==0)
                                return '<span class="label label-success">Abierto</span> <span class="label label-warning">Certificado vence hoy</span>';
                            else
                                return '<span class="label label-success">Abierto</span> <span class="label label-info">Certificado vence en '.$vencido[1].' días</span>';
                        
                            
                    }

                    
                    return Html::a(Yii::$app->formatter->asDate($model['fin'], 'dd/MM/yyyy'), Url::to(['view', 'id' => $model['id']]));
                }
            ],
            
            

            ['class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [

                    'view' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['view', 'id' =>$model['id']]));
                    },

                    'delete' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['delete', 'id' =>$model['id']]),
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
