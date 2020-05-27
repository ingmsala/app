<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Progress;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ClaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Encuentros';

in_array (Yii::$app->user->identity->role, [1,8,9]) ? $template = '{view} {update} {delete}' : $template = '{view}'

?>
<?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre', '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre']; ?>
<?php 
    $listinasistencias=ArrayHelper::map($inasistencias,'id','clase'); 
    $cantidades = array_count_values($listinasistencias);
?>


<div class="clase-index" style="margin-top: 20px;">

    
   
    
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
                in_array (Yii::$app->user->identity->role, [1,8,9]) ? Html::a('Nuevo Encuentro', ['create'], ['class' => 'btn btn-success']) : ''
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
                    //return Yii::$app->formatter->asDate($model['fecha'], 'n');
                    if(!$model['fechaconf']){
                        //if (Yii::$app->formatter->asDate($model['fecha'], 'MM')<10)

                        //return Yii::$app->formatter->asDate($model['fecha'], 'n');
                        try{
                            return $meses[Yii::$app->formatter->asDate($model['fecha'], 'MM')].'<span style="color: red;"><i> (A definir)</i><span>';
                        }catch(\Exception $exception){
                            return Yii::$app->formatter->asDate($model['fecha'], 'MM');
                        }
                        
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
                    if($model->hora != null){
                        $ini = Yii::$app->formatter->asDate($model['hora'], 'HH:mm');
                        if($model->horafin != null){
                            $fin = Yii::$app->formatter->asDate($model['horafin'], 'HH:mm');
                            return $ini.' a '.$fin;
                        }
                            
                        else
                        return $ini;
                    }
                    else
                        return '<span style="color: red;"><i>(A definir)</i><span>';
                }
            ],
            
            'tema',
            
            [
                'label' => 'Tipo de Encuentro',
                'attribute' => 'tipoclase0.nombre',
            ],
            [
                'label' => 'Tipo de Asistencia',
                'attribute' => 'tipoasistencia0.nombre',
            ],
            
            [
                'label' => 'Ausentes',
                //'attribute' => 'estadomatricula0.nombre',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model) use($cantidades){
                    
                    
                    try{
                        return $cantidades[$model->id];
                    }catch(\Exception $exception){
                        return 0;
                    }
                    
                    
                }
                
            ],
            

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'view' => function($url, $model, $key){
                        if($model['fechaconf']==0 || $model['hora'] == null)
                            return '';
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=sociocomunitarios/clase/view&id='.$model['id']);
                    },
                    'update' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=sociocomunitarios/clase/update&id='.$model['id']);
                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=sociocomunitarios/clase/delete&id='.$model['id'], 
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
