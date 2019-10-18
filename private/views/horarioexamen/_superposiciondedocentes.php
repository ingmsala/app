<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;


/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioexamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes con horas superpuestas';

?>
<div class="horarioexamen-index">

    
        
    <?= GridView::widget([
        'dataProvider' => $providerdocentes,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => ($providerdocentes->totalCount > 0) ? GridView::TYPE_DANGER : GridView::TYPE_SUCCESS,
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
                'label' => 'Docente',
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
            ],

                                
            
            
            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{viewdetcat}',

                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key) use ($col){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=horarioexamen/completoxdocente&docente='.$model['id'].'&col='.$col);
                    },

                    
                ]

            ],
        ],
    ]); ?>
</div>
