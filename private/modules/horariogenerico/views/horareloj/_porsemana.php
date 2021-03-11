<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\horariogenerico\models\HorarelojSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="horareloj-index">


    <?php
    if($dataProvider->getTotalCount()>0)
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            
            [
                'label' => 'Hora de clase',
                'value'=> function($model){
                    return $model->hora0->nombre;
                }
            ],

            [
                'label' => 'Año',
                'value'=> function($model){
                    return $model->anio.'°';
                }
            ],
            [
                'label' => 'Turno',
                'value'=> function($model){
                    return $model->turno0->nombre;
                }
            ],
            
            [
                'label' => 'Horario',
                'format' => 'raw',
                'value'=> function($model){
                    $hora = explode(':', $model->inicio);
                    $horafin = explode(':', $model->fin);
                    return Html::button($hora[0].':'.$hora[1].' a '.$horafin[0].':'.$horafin[1], ['value' => Url::to(['/horariogenerico/horareloj/update', 'id' => $model->id]), 'title' => 'Modificar hora', 'class' => 'btn btn-link amodalgenerico']);
                    return $hora[0].':'.$hora[1];
                }
            ],
                        

            /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'

            ],*/
        ],
    ]); ?>
</div>
<div class="pull-right">
<?php
    if($dataProvider->getTotalCount()>0)
        echo Html::a('<span class="glyphicon glyphicon-cog"></span> Exportar horarios desde el original', Url::to(['/horariogenerico/horariogeneric/generar', 'anio' => $anio, 'semana' => $semana, 'turno' => $turno]), 
            [   
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Se exportarán los horarios y sobreescribirán todos los cambios particulares que tenga el horario para esta semana. ¿Está seguro de querer proceder?',
                    'method' => 'post',
                ]
            ]);
    
?>
</div>
<div class="clearfix"></div>
<br />
<?php $form = ActiveForm::begin(); ?>
   <?php
    if($dataProvider->getTotalCount()>0 && $fechas->getTotalCount()>0)
        echo GridView::widget([
            'dataProvider' => $fechas,
            'summary' => false,
            'rowOptions' => function($model){
                //return var_dump($model);
                if($model['burbuja'] == 'Roja'){
                    return ['style' => 'background-color:#f2dede'];
                    $colorcol = '#f2dede';
                    $diaconmateria = true;
                }
                if($model['burbuja'] == 'Azul'){
                    return ['style' => 'background-color:#ADD8E6'];
                    $colorcol = '#ADD8E6';
                    $diaconmateria = true;
                }
                if($model['burbuja'] == 'Amarilla'){
                    return ['style' => 'background-color:#FFFACD'];
                    $colorcol = '#FFFACD';
                    $diaconmateria = true;
                }

                
            },
            'columns' => [
                [
                    'attribute' => 'fecha'
                ],
                [
                    'attribute' => 'burbuja'
                ],
                [
                    'label' => 'Cambiar todos a',
                    'format' => 'raw',
                    'attribute' => 'cambiar'
                ],
            ]
        ]);
    ?>

<?php ActiveForm::end(); ?>
