<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RevistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Padrón Preceptores - '.$propuesta;
$this->params['breadcrumbs'][] = ['label' => 'Padrones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $listjefessec=ArrayHelper::map($jefessec,'id','id'); ?>
<?php $listjefespre=ArrayHelper::map($jefespre,'id','id'); ?>
<?php $listprecsec=ArrayHelper::map($precsec,'id','id'); ?>
<?php $listprecpre=ArrayHelper::map($precpre,'id','id'); ?>
<?php $listdocsec=ArrayHelper::map($docsec,'id','id'); ?>
<?php $listdocpre=ArrayHelper::map($docpre,'id','id'); ?>
<?php $listotrosdoc=ArrayHelper::map($otrosdoc,'id','id'); ?>
<?php $listotrosdocpre=ArrayHelper::map($otrosdocpre,'id','id'); ?>


<div class="revista-index">

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],

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
           
            [
                'label' => 'Legajo',
                'value' => function($model){
                    return $model['legajo'];
                }
            ],

            [
                'label' => 'Documento',
                'value' => function($model){
                    return $model['documento'];
                }
            ],
            
            [
                'label' => 'Preceptor/a',
                'value' => function($model){
                    return $model['apellido'].', '.$model['nombre'];
                }
            ],

            [
                'label' => 'Aparece en otros padrones',
                'headerOptions' => ['style' => 'width:20%'],
                'format' => 'raw',
                'value' => function($model) use($propuesta, $listdocsec, $listdocpre, $listjefessec, $listjefespre, $listotrosdoc, $listprecsec, $listprecpre, $listotrosdocpre) {
                    $ret = '<ul>';
                    if (in_array ($model->id, $listdocsec)){
                        $ret .= '<li>Docente Secundario</li>';
                    }
                    if (in_array ($model->id, $listdocpre)){
                        $ret .= '<li>Docente Pregrado</li>';
                    }
                    if (in_array ($model->id, $listjefessec)){
                        $ret .= '<li>Jefe Secundario</li>';
                    }
                    if (in_array ($model->id, $listjefespre)){
                        $ret .= '<li>Jefe Pregrado</li>';
                    }
                    if (in_array ($model->id, $listotrosdoc)){
                        $ret .= '<li>Otros docentes Secundario</li>';
                    }
                    if (in_array ($model->id, $listotrosdocpre)){
                        $ret .= '<li>Otros docentes Pregrado</li>';
                    }
                    if($propuesta == 'SECUNDARIO'){
                        if (in_array ($model->id, $listprecpre)){
                            $ret .= '<li>Preceptor Pregrado</li>';
                        }
                    }else{
                        if (in_array ($model->id, $listprecsec)){
                            $ret .= '<li>Preceptor Secundario</li>';
                        }
                    }
                    

                    $ret .= '</ul>';
                    return $ret;
                }
            ],

            [
                'label' => '',
                'headerOptions' => ['style' => 'width:20%'],
                'value' => function($model){
                    return '';
                }
            ],
            [
                'label' => '',
                'headerOptions' => ['style' => 'width:20%'],
                'value' => function($model){
                    return '';
                }
            ],

                       
            
            
            
            

            
        ],
    ]); ?>
</div>