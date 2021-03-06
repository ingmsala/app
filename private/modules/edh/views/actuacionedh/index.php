<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\ActuacionedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actuaciones';
$this->params['breadcrumbs'][] = $this->title;
$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model,
    'origen' => 'actuaciones',
];
?>
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>".'Actuación del  Caso #'.$model->id."</h2>",
            'id' => 'modaldetalleticket',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="actuacionedh-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            'footer' => false,
            'after' => false,
            'before' =>Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar actuación', ['value' => Url::to('index.php?r=edh/actuacionedh/create&caso='.$model->id), 'class' => 'btn btn-main btn-success amodaldetalleticket contenedorlistado'])
        ],
        'toolbar'=>[
            
            
            
        ],
        'summary' => false,
        'condensed' => true,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'label' => 'Área de Recepción',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    try {
                        return $model->area0->nombre;
                    } catch (\Throwable $th) {
                        return '';
                    }
                    
                }
            ],
            [
                'label' => 'Fecha',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Actores',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'format' => 'raw', 
                'value' => function($model){
                    if(count($model->actorxactuacions)>0){
                        $ret = '<ul>';
                        foreach ($model->actorxactuacions as $axa) {
                            $ret .= '<li>'.$axa->persona0->apellido.', '.$axa->persona0->nombre.'</li>';
                        }
                        $ret .= '</ul>';
                        return $ret;
                    }
                    return $model->agente0->apellido.', '.$model->agente0->nombre;
                    
                }
            ],
            [
                'label' => 'Lugar de actuación',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'value' => function($model){
                    try {
                        return $model->lugaractuacion0->nombre;
                    } catch (\Throwable $th) {
                        return '';
                    }
                    
                }
            ],

            [
                'label' => 'Registro',
                'vAlign' => 'middle', 
                //'hAlign' => 'center', 
                'value' => function($model){
                    return $model->registro;
                }
            ],
            
            [
                'label' => 'Se informa a',
                'vAlign' => 'middle', 
                'hAlign' => 'center', 
                'format' => 'raw', 
                'value' => function($model){
                    $ret = '<ul>';
                    foreach ($model->areainformaacts as $axa) {
                        $ret .= '<li>'.$axa->area0->nombre.'</li>';
                    }
                    $ret .= '</ul>';
                    return $ret;
                    
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function($url, $model, $key){
                        if($model->tipoactuacion == 1)
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to(['actuacionedh/update', 'id' => $model->id]),
                                'class' => 'amodaldetalleticket btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);


                    },
                    
                    'delete' => function($url, $model, $key){
                        if($model->tipoactuacion == 1)
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['actuacionedh/delete', 'id' => $model->id]), 
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
