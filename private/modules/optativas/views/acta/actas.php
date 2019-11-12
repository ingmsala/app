<?php

use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ActaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actas';

if(Yii::$app->request->get('cl')==1){
    $botones = '{cerrar}';
}elseif(Yii::$app->request->get('cl')==0){
    $botones = '{cargar}';
}else{
     $botones = '';
}

?>
<div class="acta-index">

    
      <?php
   

        $form2 = ActiveForm::begin([
                                    'action' => ['create'],
                                    'method' => 'get',
                ]);
        
        echo $form2->field($model, 'aniolectivo')->hiddenInput()->label(false);
        echo $form2->field($model, 'comision')->hiddenInput()->label(false);
        echo '<p class="pull-right">';
        
        echo '</p>';                        
      
        

        echo '<div class="clearfix"></div>';
        
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => $this->title,
                    //'beforeOptions' => ['class'=>'kv-panel-before'],
                    //'footer' => false,
                    'bordered' => false,
                    
                   
        ],

        'toolbar'=>[
            ['content' => !(Yii::$app->request->get('cl')==1) ?
                Html::submitButton('Nueva Acta', ['class' => 'btn btn-success']) : ''

            ],
            
            
        ],
        'columns' => [
            

            [
                'label' => 'Libro',
                'value' => function($model){
                    return $model->libro0->nombre;
                }
            ],
            
            [
                'label' => 'Acta',
                'value' => function($model){
                    return $model->nombre;
                }
            ],
            

            [
                'label' => 'Actividad',
                'value' => function($model){
                    return $model->comision0->optativa0->actividad0->nombre;
                }
            ],

            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            

            [
                'label' => 'Rectifica',
                'value' => function($model){
                    if ($model->rectifica == null)
                        return 'No';
                    return $model->rectifica;
                }
            ],

            [
                    'class' => 'kartik\grid\BooleanColumn',
                    //'attribute' => 'estadoacta0', 
                    'hiddenFromExport' => true,
                    'label' => 'Estado',
                    'vAlign' => 'middle',
                    'trueIcon' => '<span class="glyphicon glyphicon-record text-success"></span>',
                    'falseIcon' => '<span class="glyphicon glyphicon-record text-danger"></span>',
                    'value' => function ($model){
                        if($model->estadoacta == 1)
                            return true;
                        return false;
                        
                    }
            ],

            [
                    'class' => 'kartik\grid\ActionColumn',
                    
                    'template' => $botones,
                    
                    'buttons' => [

                        'cargar' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '?r=optativas/acta/view&id='.$model->id);
                        },

                        'cerrar' => function($url, $model, $key){
                            if($model->estadoacta==1)
                                $gly = 'lock';
                            else
                                $gly = 'eye-open';
                        return Html::a('<span class="glyphicon glyphicon-'.$gly.'"></span>', '?r=optativas/detalleacta/cerraracta&acta_id='.$model->id);
                        },
                        
                        
                        
                        
                    ]

            ],
        ],
    ]); 
    
    ActiveForm::end();

    ?>
</div>
