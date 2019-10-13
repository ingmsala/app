<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;

if(Yii::$app->user->identity->role==Globales::US_SUPER)
     $template = '{dethorarios} {viewdetcat} {deletedetcat}';
else
    $template = '{deletedetcat}';

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios a exámenes';

?>
<div class="horarioexamen-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
            '{export}',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                     
            
            [
                'label' => 'Año Lectivo',
                'attribute' => 'anioxtrimestral0.aniolectivo0.nombre',
            ],
            [
                'label' => 'Instancia',
                'attribute' => 'anioxtrimestral0.trimestral0.nombre',
            ],
            [
                'label' => 'Division',
                'attribute' => 'catedra0.division0.nombre',
            ],
            [
                'label' => 'Materia',
                'attribute' => 'catedra0.actividad0.nombre',
            ],

            [
                'label' => 'Fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],

            [
                'label' => 'Docente',
                'value' => function ($model){
                    $dcs = $model->catedra0->detallecatedras;
                    foreach ($dcs as $dc) {
                        if ($dc->revista == 6){
                            return $dc->docente0->apellido.', '.$dc->docente0->nombre;
                        }
                    }
                    return '';
                }
            ],
            [
                'label' => 'Hora',
                'attribute' => 'hora0.nombre',
            ],
            
            
            
            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => $template,

                
                'buttons' => [
                    'dethorarios' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=horarioexamen/view&id='.$model->id);
                    },

                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            '?r=horarioexamen/update&id='.$model->id);
                    },
                    
                    'deletedetcat' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=horarioexamen/delete&id='.$model->id, 
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
