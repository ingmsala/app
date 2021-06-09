<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\libroclase\models\desarrollo\DesarrolloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$titulo = $catedra->division0->nombre.' - Desarrollos de programa '.$aniolectivo->nombre.': '.$catedra->actividad0->nombre;

?>
<div class="desarrollo-index">

    <h1><?= Html::encode($titulo) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        if($dataProvider->getTotalCount()>0)
            echo Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Desarrollo', ['create', 'cat' => $catedra->id], 
                                    [
                                    'class' => 'btn btn-success',  
                                    'data' => [
                                    'confirm' => 'Ya existe un desarrollo de programa para esta materia, desea crear uno nuevo?',
                                    'method' => 'post',
                                     ]
                                    ]);
        else
            echo Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Desarrollo', ['create', 'cat' => $catedra->id], 
            [
            'class' => 'btn btn-success',  
            'data' => [
            'method' => 'post',
            ]
            ]);
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'aniolectivo0.nombre',
            'docente0.nombrecompleto',
            'estado0.nombre',
            [
                'attribute' => 'fechacreacion',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->fechacreacion, 'dd/MM/yyyy');
                }
            ],
            
            [
                'label' => 'Acción',
                'format' => 'raw',
                'value' => function($model){
                    if($model->estado==1)
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span> Continuar completando...',
                            ['view', 't' => $model->token], ['class' => 'btn btn-primary']);
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span> Ver',
                        ['view', 't' => $model->token], ['class' => 'btn btn-info']);
                }
            ],
        ],
    ]); ?>
</div>
