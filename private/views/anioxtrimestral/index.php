<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnioxtrimestralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exámenes por año';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->identity->role==Globales::US_SUPER)
     $template = '{dethorarios} {viewdetcat} {deletedetcat}';
else
    $template = '{viewdetcat}';

?>
<div class="anioxtrimestral-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Examen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'aniolectivo0.nombre',
            [
                'label' => 'Instancia',
                'attribute' => 'trimestral0.nombre',
            ],
            [
                'label' => 'Inicio',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy');
                 
                }
            ],
            [
                'label' => 'Fin',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return ($model->activo==1) ? 'Activo' : 'Inactivo';
                }
            ],
            [
                'label' => 'Publicado?',
                'value' => function($model){
                    return ($model->publicado==1) ? 'Sí' : 'No';
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'dethorarios' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=horarioexamen/index&id='.$model->id);
                    },

                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=anioxtrimestral/update&id='.$model->id);
                    },
                    
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=anioxtrimestral/delete&id='.$model->id, 
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
