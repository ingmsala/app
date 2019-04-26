<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ClaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';

in_array (Yii::$app->user->identity->role, [1,8,9]) ? $template = '{view} {update} {delete}' : $template = '{view}'

?>
<?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre']; ?>

<div class="clase-index" style="margin-top: 20px;">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'rowOptions' => function($model){

                                    if($model->fechaconf == 1 && $model->hora != null)
                                        return ['class' => 'success'];
                                    
                                    return ['class' => 'warning'];
                                },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
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
            ['content' => 
                in_array (Yii::$app->user->identity->role, [1,8,9]) ? Html::a('Nueva Clase', ['create'], ['class' => 'btn btn-success']) : ''
            ],
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model) use($meses){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    if(!$model['fechaconf']){
                        return $meses[Yii::$app->formatter->asDate($model['fecha'], 'n')].'<span style="color: red;"><i> (A definir)</i><span>';
                    }
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Horario',
                'format' => 'raw',
                'value' => function($model){
                    if($model->hora != null)
                        return $model->hora;
                    else
                        return '<span style="color: red;"><i>(A definir)</i><span>';
                }
            ],
            'tema',
            [
                'label' => 'Comisión',
                'attribute' => 'comision0.nombre',
            ],
            [
                'label' => 'Tipo de Clase',
                'attribute' => 'tipoclase0.nombre',
            ],
            'horascatedra',
            

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        if($model['fechaconf']==0 || $model['hora'] == null)
                            return '';
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=optativas/clase/view&id='.$model['id']);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=optativas/clase/update&id='.$model['id']);
                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=optativas/clase/delete&id='.$model['id'], 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },
                ]

            ],
        ],
    ]); 


   

    ?>


    


</div>
