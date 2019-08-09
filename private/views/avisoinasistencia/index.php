<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AvisoinasistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aviso de Inasistencias';
$this->params['breadcrumbs'][] = $this->title;

if(in_array (Yii::$app->user->identity->role, [1,4]))
        $template =  "{edit} {delete}";
    else
        $template =  "";
?>
<div class="avisoinasistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            if(in_array (Yii::$app->user->identity->role, [1,4]))
                echo Html::a('Nuevo aviso', ['create'], ['class' => 'btn btn-success']); 
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        
            [
                'label' => 'Docente',
                'value' => function ($model){
                    return $model->docente0['apellido'].', '.$model->docente0['nombre'];
                }
            ],
            'descripcion:ntext',
            [
                'label' => 'Desde',
                'attribute' => 'desde',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['desde'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['desde'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Hasta',
                'attribute' => 'hasta',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['hasta'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['hasta'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['hasta'], 'dd/MM/yyyy');
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'edit' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=avisoinasistencia/update&id='.$model['id']);
                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=avisoinasistencia/delete&id='.$model['id'], 
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
