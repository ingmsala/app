<?php

use app\modules\sociocomunitarios\models\Detallerubrica;
use app\modules\sociocomunitarios\models\Rubrica;
use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */

$this->title = $matr->alumno0->apellido.', '.$matr->alumno0->nombre;
in_array (Yii::$app->user->identity->role, [1,8,20]) ? $template = '{update} {delete}' : $template = '';
?>
<div class="seguimiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= in_array (Yii::$app->user->identity->role, [1,8]) ? Html::a('Nuevo Seguimiento', ['create', 'id' => $matricula], ['class' => 'btn btn-success']) : '' ?>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'label' => 'Trimestre',
                'value' => function($model){
                    return $model->trimestre.'°trimestre';
                },
                
            ],
            
            [
                'label' => 'Tipo',
                'attribute' => 'tiposeguimiento0.nombre',
                
            ],
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            'descripcion',

            [
                'label' => 'Estado',
                'attribute' => 'estadoseguimiento0.nombre',
                
            ],

            [
                'label' => 'Rúbrica',
                'value' => function($model){
                    $rubricas = count(Rubrica::find()->where(['curso' => $model->matricula0->comision0->espaciocurricular0->curso])->all());
                    $dr = count(Detallerubrica::find()->where(['seguimiento' => $model->id])->all());
                    if($model->tiposeguimiento == 3)
                        return '';
                    if($dr<$rubricas){
                        return "Incompleta";
                    }
                    return "Completa";
                }

            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => $template,
                
                'buttons' => [
                    'update' => function($url, $model, $key){
                        if($model->tiposeguimiento == 3)
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                '?r=sociocomunitarios/seguimiento/update&id='.$model->id);
                        else
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                '?r=sociocomunitarios/seguimiento/rubrica&id='.$model->id);
                                
                    },
                    'delete' => function($url, $model, $key){
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=sociocomunitarios/seguimiento/delete&id='.$model->id, 
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
