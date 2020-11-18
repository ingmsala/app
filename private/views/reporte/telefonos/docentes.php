<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';

?>
<div class="docente-index">

    <?php
        if(in_array (Yii::$app->user->identity->role, [1]))
        $template =  "{viewdetcat}";
    else
        $template =  " ";

    ?>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'condensed' => true,

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
                'label' => 'Legajo',
                'attribute' => 'legajo',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                
            ],
            [
                'label' => 'Documento',
                'attribute' => 'documento',
                               
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],
            [
                'label' => 'Docente',
                'attribute' => 'apellido',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'value' => function($model){
                    return $model->apellido.', '.$model->nombre;
                }
            ],

            [
                'label' => 'Teléfono',
                'attribute' => 'telefono',
                               
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],

            [
                'label' => 'Mail',
                'attribute' => 'mail',
                               
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                //'width' => '7%',
                
            ],

                                              
            

            
        ],
    ]); ?>
</div>
