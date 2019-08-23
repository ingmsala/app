<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Nombramiento;
use app\models\Docente;


/* @var $this yii\web\View */
/* @var $searchModel app\models\NombramientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nombramientos';


?>
    
    <?= $this->render('_filter', [
        'model' => $model,

        'cargos' => $cargos,
        'docentes' => $docentes,
        'revistas' => $revistas,
        'condiciones' => $condiciones,
        'resoluciones' => $resoluciones,
        'resolucionesext' => $resolucionesext,
        'param' => $param,
        
    ]) ?>

           
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            return ['id' => $model['id']];
        },
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,

            'heading' => Html::encode($this->title)
            
            ],
        'columns' => [
        
            [
                'label' => 'Cod. Cargo',
                'attribute' => 'cargo',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return $model->cargo.' - '.$model->cargo0->nombre;
                }
            ],

            [
                'label' => 'Revista',
                'attribute' => 'revista',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return Html::tag('span',  $model->revista0->nombre, ['class' => "badge"]);
                }
            ],
           
            [
                'label' => 'Docente',
                'attribute' => 'docente',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                
                'value' => function($model){

                    return $model->docente0->apellido.', '.$model->docente0->nombre;
                   //return $model->docente0->apellido.', '.$model->docente0->nombre;
                }

            ],

            [
                'label' => 'Condición',
                'attribute' => 'condicion',
                'format' => 'raw',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){

                   return Html::tag('span',  $model->condicion0->nombre, ['class' => "badge"]);
                }
            ],

                     
            
            [
                'label' => 'Función (Horas)',
                'attribute' => 'division',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model->nombre.'('.$model->horas.')';
                }
            ],
            [
                'label' => 'Suplente',
                'attribute' => 'suplente',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' =>  function($model){
                     //var_dump($model->suplente0->docente0);
                        if (isset($model->suplente0)){
                            //$suplentes = ArrayHelper::map($model, 'id', 'docente');
                            //var_dump($model->suplente0->suplente);
                            
                            return Html::tag('li', Html::tag('div',Html::tag('span', $model->suplente0->condicion0->nombre, ['class' => "badge pull-left"]).Html::tag('span', $model->suplente0->revista0->nombre, ['class' => "badge pull-right"])."&nbsp;".$model->suplente0->docente0->apellido.', '.$model->suplente0->docente0->nombre, ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);
                        }

                        return '';
                    }
                     
                
                //'suplente0.docente0.apellido',
            ],

            [
                'label' => 'Suplente 2',
                'attribute' => 'suplente0',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' =>  function($model){
                     //var_dump($model->suplente0->docente0);
                        if ($model->suplente0 != null){

                            if ($model->suplente0->suplente != null){
                                $supl = new Nombramiento();
                                $supl = $supl->getsuplente($model->suplente0->suplente);
                                $supl = Docente::findOne($supl['docente']);
                                //return $supl['apellido'].', '.$supl['nombre'];
                            
                            
                            //var_dump();
                                return Html::tag('li', Html::tag('div',Html::tag('span', 'SUPL', ['class' => "badge pull-left"]).Html::tag('span', 'VIGENTE', ['class' => "badge pull-right"])."&nbsp;".$supl['apellido'].', '.$supl['nombre'], ['data-toggle' => "pill"]), ['class' => 'list-group-item list-group-item-info']);

                            }
                        }

                        return '';
                    }
                     
                
                //'suplente0.docente0.apellido',
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],

         'toolbar'=>[
            ['content' => 
                Html::a('Nuevo Nombramiento', ['create'], ['class' => 'btn btn-success']),

               
            ],
            '{export}',
            
        ],
        //'floatHeader'=>true,
        'summary'=>false,
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel', 
                'filename' =>Html::encode($this->title),
                'config' => [
                    'worksheet' => Html::encode($this->title),
            
                ]
            ],
            //GridView::HTML => [// html settings],
            GridView::PDF => ['label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => 'Portable Document Format'],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
            ],
        ]
        
    ]); ?>
</div>
