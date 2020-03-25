<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cátedras con Inconsistencias';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div class="alert alert-danger" role="alert">Error. Debe corregir las siguientes cátedras que tienen más de un docente en estado VIGENTE</div>

    

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            
            
            //'id',
            'division',
            'actividad',
                        

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                '?r=catedra/view&id='.$model['catedra']);


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>