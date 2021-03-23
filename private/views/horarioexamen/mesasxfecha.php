<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;


/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios a exámenes';

?>
<div class="horarioexamen-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $providercursos,
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
                'label' => 'Instancia',
                'attribute' => 'anioxtrimestral0.trimestral0.nombre',
            ],
            [
                'label' => 'Fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
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
                'label' => 'Docente',
                'value' => function ($model){
                    $dcs = $model->catedra0->detallecatedras;
                    foreach ($dcs as $dc) {
                        if ($dc->revista == 6 && $model->anioxtrimestral0->aniolectivo == 2){
                            return $dc->agente0->apellido.', '.$dc->agente0->nombre;
                        }
                    }
                    return '';
                }
            ],
            [
                'label' => 'Hora',
                'attribute' => 'hora0.nombre',
            ],
            
            
            
            
        ],
    ]); ?>
</div>
