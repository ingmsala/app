<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\mones\models\MonacademicaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Historial Académico';

?>
<div class="monacademica-index">

<?php

    if($pr == 0){
        echo DetailView::widget([
            'model' => $alumno,
            'attributes' => [
                'apellido',
                'nombre',
                [
                    'label' => 'Información',
                    'value' => 'El presente documento no reemplaza bajo ningún punto de vista las actas originales en papel ni certifica que los datos concuerden con las mismas'
                ],
    
            ],
        ]);
    }
     ?>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div  class="pull-right">
            <?php 
                
                echo Html::a('<center><span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Imprimir</center>', Url::to(['printhistorial', 'doc' => $alumno->documento, 'car' => $carrera->id]), ['class' => 'btn btn-default']);
            ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<h2>'.Html::encode("Historial Académico").'</h2>',
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        

        'toolbar'=>[
           
            '',
            
        ],
        'columns' => [
            
            
            [
                'label' => 'Curso',
                //'attribute' => 'curso',
                'vAlign' => 'middle',
                //'value' => 'actividad0.nombre',
                'value' => function($model){
                    return $model->curso;
                },
                'group' => true,
            ],
            [
                'label' => 'Materia',
                'value' => function($model){
                    return $model->materia0->nombre;
                }
            ],
            [
                'label' => 'Condición',
                'value' => function($model){
                    return $model->condicion;
                }
            ],
            [
                'label' => 'Nota',
                'value' => function($model){
                    return $model->nota;
                }
            ],
            //'alumno',
            
            [
                'label' => 'Fecha',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],

            
        ],
    ]); ?>
</div>
