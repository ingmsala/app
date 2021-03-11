<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Semana */



?>
<div class="semana-create">

<?php 

    if($tiposemana != 'ss'){
    echo '<br />';
        echo Html::a('Generar horario masivo - '.$tiposemana, Url::to(['operarmasivo', 'semana' => $semana, 'origen' => $origen]), [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Esta acción, copia los horarios originales del año lectivo al horario semanal. Si hizo cambios los perderá. Está seguro que desea <b>generar masivamente</b> el horario de la semana de todos los cursos?',
                    'method' => 'post',
                ],
                ]);
        
        echo '<div class="clearfix"></div>';
        echo '<br />';
    }else
        echo '<div class="alert alert-warning">
        <strong>Info</strong> Debe designar el tipo de semana como <i>Virtual</i> o <i>Presencial</i> para generar masivamente los horarios.
        </div>';

?>

    
<?php $form = ActiveForm::begin(['action' => Url::to('index.php?r=semana/operarmasivos&origen='.$origen)]); ?>
<div id="horas-reloj2">
            <?php
                echo GridView::widget([
                    'dataProvider' => $fechasmasivas,
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

            </div>

<?php ActiveForm::end(); ?>

<?php

    if($origen == 'index'){
        echo Html::a('Administrar semana', Url::to(['view', 'id' => $semana]), [
            'class' => 'btn btn-success pull-right',
            ]);
    }

?>

</div>
