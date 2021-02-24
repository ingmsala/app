<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Solicitudinscripext */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="solicitudinscripext-view">

    <h3><?= Html::encode('Constancia de Solicitud de Inscripción a exámenes previos/libres') ?></h3>

    <?php


    echo Html::a('<span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Descargar comprobante', '?r=solicitudprevios/crear/imprimir&id='.$model->id, 
                                        ['class' => 'pull-right btn btn-default',
                                            'data' => [
                                            'method' => 'post',
                                            ]
                                        ])


    ?>

    <br/>
    <br/>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'N° solicitud',
                'value' => function($model){
                    
                    return '#'.str_pad($model->id, 8, "0", STR_PAD_LEFT);

                }
            ],
            [
                'label' => 'Fecha de solicitud',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Estudiante',
                'value' => function($model){
                    return $model->apellido.', '.$model->nombre;
                }
            ],
            
            'documento',
            
            [
                'label' => 'Turno de examen',
                'value' => function($model){
                    return $model->turno0->nombre;
                }
            ],
            
            'mail',
            'telefono',
            [
                'label' => 'Materias',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    foreach ($model->detallesolicitudexts as $detalle) {
                        $salida .= '<li>'.$detalle->actividad0->nombre.'</li>';
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ]
        ],
    ]) ?>

</div>
