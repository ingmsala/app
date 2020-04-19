<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';
$this->params['breadcrumbs'][] = $this->title;
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
            ['content' => 
                Html::a('Nuevo Docente', ['create'], ['class' => 'btn btn-success'])

            ],
            '{export}',
            
        ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'legajo',
                'hAlign' => 'left', 
                'vAlign' => 'middle',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . ((strlen($model->legajo)>6 || empty($model->legajo))  ? '#f2dede' : '')];
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'documento',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'background-color:' 
                        . (empty($model->documento)
                            ? '#f2dede' : '')];
                }, 

                'readonly' => function($model, $key, $index, $widget) {
                    return (!in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA])); // do not allow editing of inactive records
                },

                'editableOptions' => [
                    'header' => 'Documento', 
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => ['/docente/editdocumento']],
                ],
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
                                   
            

            ['class' => 'yii\grid\ActionColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $template,
                'visible' => (in_array (Yii::$app->user->identity->role, [1])) ? true : false,
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=horario/prueba&url=https://empleados.unc.edu.ar/autogestion/traeDatosEmpleado.php?lj='.$model['legajo']);
                    },
                    
                ]

            ],
        ],
    ]); ?>
</div>
