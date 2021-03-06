<?php

use app\config\Globales;
use kartik\base\Config;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\markdown\Markdown;
use kartik\markdown\Module;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\SeguimientoplanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seguimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguimientoplan-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="pull-right">
                <?php
                    if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION])){
                        echo Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar seguimiento', ['value' => Url::to('index.php?r=edh/seguimientoplan/create&plan='.$plan), 'title' =>'Agregar seguimiento', 'class' => 'btn btn-success amodalplancursado']);

                    }
                ?>                
                </p>
    <div class="clearfix"></div>

    <?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'responsiveWrap' => false,
        'condensed' => true,
        'responsiveWrap' => false,
        'bordered' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                'format' => 'raw',
                'width' => '10%',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $lbl = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                    if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION])){
                        return $lbl;
                    }
                    return Html::button($lbl,
                    ['value' => Url::to(['seguimientoplan/update', 'id' => $model->id]),
                    'title' => 'Modificar seguimiento',
                        'class' => 'amodalplancursado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                }
            ],
            [
                'label' => 'Descripción',
                'format' => 'raw',
                'value' => function($model){
                    $module = Config::getModule(Module::MODULE);
                    $output = Markdown::convert($model->descripcion, ['custom' => $module->customConversion]);
                    if(!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_COORDINACION])){
                        return $output;
                    }
                    return Html::button($output,
                    ['value' => Url::to(['seguimientoplan/update', 'id' => $model->id]),
                    'title' => 'Modificar seguimiento',
                        'class' => 'amodalplancursado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                    //return $output;
                }
            ],
            
            /*[
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to(['seguimientoplan/update', 'id' => $model->id]),
                            'title' => 'Modificar seguimiento',
                                'class' => 'amodalplancursado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);


                    },
                    
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['seguimientoplan/delete', 'id' => $model->id]), 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]);
                    },

                ]
            
            ],*/
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
