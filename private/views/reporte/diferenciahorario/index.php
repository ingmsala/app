<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Diferencia de Docentes en Planta vs Horario';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            
            
            //'id',
            'division',
            'actividad',
            'vigente',
            'horario',
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                '?r=catedra/view&id='.$model['id']);


                    },
                    
                ]

            ],
        ],
    ]); ?>


</div>