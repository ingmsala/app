<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */

$this->title = "Catedra";
$this->params['breadcrumbs'][] = ['label' => 'Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catedra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de querer eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['label'=>"Actividad",
            'attribute' =>'actividad0.nombre'],
            ['label'=>"División",
            'attribute' =>'division0.nombre'],
        ],
    ]) ?>


    
    <h3>Docentes Nombrados</h3>
    <?= Html::a('Agregar Docente', ['detalle-catedra/create', 'catedra' => $model->id], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            
            [   
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre'
            ],
            
            [   
                'label' => 'Docente',
                'attribute' => 'docente0.apellido'
            ],
            
            [   
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],

           // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat} {updatedetcat} {deletedetcat}',
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=detalle-catedra/view&id='.$model->id) : '';
                    },
                    'updatedetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=detalle-catedra/update&id='.$model->id) : '';


                    },
                    'deletedetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=detalle-catedra/delete&id='.$model->id, 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]) : '';
                    },
                ]

            ],
        ],
    ]); ?>

   

</div>
