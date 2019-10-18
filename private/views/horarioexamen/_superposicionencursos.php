<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;


/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horas repetidas en el curso';

?>
<div class="horarioexamen-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $providercursos,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => ($providercursos->totalCount > 0) ? GridView::TYPE_DANGER : GridView::TYPE_SUCCESS,
            'heading' => Html::encode($this->title),
            'footer' => false,
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'toolbar'=>[
            '',
            
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                     
            
            [
                'label' => 'División',
                'value' => function($model){
                    return $model['division'];
                }
            ],

            [
                'label' => 'Materia',
                'value' => function($model){
                    return $model['materia'];
                }
            ],
                     
            
            
            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{viewdetcat}',

                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key) use ($col) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=horarioexamen/completoxcurso&division='.$model['id'].'&vista=docentes&prt=0&col='.$col);
                    },

                    
                ]

            ],
        ],
    ]); ?>
</div>
