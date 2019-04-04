<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NovedadesparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Novedades del parte';

?>
<div class="novedadesparte-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Nueva Novedad', ['value' => Url::to('index.php?r=novedadesparte/create&parte='.$model->id.'&preceptoria='.$model->preceptoria), 'class' => 'btn btn-success', 'id'=>'modalaNovedadesParte']) ?>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                
            [   
                'label' => 'Fecha',
                'attribute' => 'parte0.fecha',
               
                'value' => function($model){
                    //var_dump($model);
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                    
                }
            ],
            [

                'label' => 'Preceptoria',
                'attribute' => 'parte0.preceptoria0.nombre',
            ],

            [

                'label' => 'Tipo de Novedad',
                'attribute' => 'tiponovedad0.nombre',
            ],
            
            
            [
                'label' => 'Preceptor',
                'value' => function($model){
                    if($model->docente0 != null)
                        return $model->docente0['apellido'].', '.$model->docente0['nombre'];
                    else
                        return '';
                }
            ],
            
            
            'descripcion:ntext',
            [

                'label' => 'Estado',
                'attribute' => 'estadonovedad0.nombre',
            ],

            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{update} {delete}',
                
                'buttons' => [
                    
                    'update' => function($url, $model, $key){
                        if($model->estadonovedad == 1 or in_array (Yii::$app->user->identity->role, [1]))
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to('index.php?r=novedadesparte/update&id='.$model->id.'&parte=' .$model->parte),
                                'class' => 'modala btn btn-link', 'id'=>'modalaModificarNovedad']);


                    },
                    'delete' => function($url, $model, $key){
                        if($model->estadonovedad == 1 or in_array (Yii::$app->user->identity->role, [1]))
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=novedadesparte/delete&id='.$model->id, 
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
