<?php

use app\modules\edh\models\Caso;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CasoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Casos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caso-index">

<?= $this->render('_search', [
        'param' => $param,
        'model' => $model,
        'alumnos' => $alumnos,
        'estadoscaso' => $estadoscaso,
        'casos' => $casos,
        'aniolectivos' => $aniolectivos,
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva solicitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
                    if($model['estadocaso'] == 'Cerrado')
                            return '<span class="label label-default">Cerrado</span>';
                    $caso = Caso::findOne($model['id']);
                    if($caso->vencido[0]){
                        return '<span class="label label-success">Abierto</span><span class="label label-danger">Certificado vencido</span>';
                    }else{
                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                            $interval = date_diff(date_create(date('Y-m-d')), date_create($caso->vencido[1]));
                            if($interval->d>5)
                                return '<span class="label label-success">Abierto</span>';
                            elseif($interval->d==1)
                                return '<span class="label label-success">Abierto</span><span class="label label-warning">Certificado vence en '.$interval->d.' día</span>';
                            elseif($interval->d==0)
                                return '<span class="label label-success">Abierto</span><span class="label label-warning">Certificado vence hoy</span>';
                            else
                                return '<span class="label label-success">Abierto</span><span class="label label-info">Certificado vence en '.$interval->d.' días</span>';
                        
                            
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
