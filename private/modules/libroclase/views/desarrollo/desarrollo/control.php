<?php

use app\config\Globales;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Desarrollos de programa';
$anios=ArrayHelper::map($anios,'id','nombre');
$anio = $model->aniolectivo;

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<div class="horario-index">

    <?php $form = ActiveForm::begin(); ?>
    <?= 

    $form->field($model, 'aniolectivo')->widget(Select2::classname(), [
        'data' => $anios,
        'options' => ['placeholder' => 'Seleccionar...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('<div class="glyphicon glyphicon-search"></div> Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,

        'exportConfig' => [
            GridView::PDF => [
                'label' => 'PDF',
                'filename' =>Html::encode($this->title),
                'options' => ['title' => ''],
                'config' => [
                    'methods' => [ 
                        'SetHeader'=>[Html::encode($this->title).' - Colegio Nacional de Monserrat'], 
                        'SetFooter'=>[date('d/m/Y').' - Página '.'{PAGENO}'],
                    ]
                ],
                
                //'alertMsg' => false,
            ],

            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'columns' => [
            

            
            [
                'label' => 'División',
                //'group' => true,
                'format' => 'raw',
                'value' => function($model){
                        
                            return $model->division0->nombre;
                         
                }

            ],

            [
                'label' =>'Materia',
                //'group' => true,
                'attribute' => 'actividad0.nombre',
            ],

            [
                'label' =>'Último docente del año lectivo',
                'format' => 'raw',
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                            break;
                        }
                    }

                    try {
                        $docente = Html::a($doc, Url::to(['/detallecatedra/updatehorario', 'id' => $dc->id, 'or' => 'cont']), ['class' => 'btn btn-link']);
                    } catch (\Throwable $th) {
                        $docente = Html::a('Agregar docente', Url::to(['/detallecatedra/updatehorario', 'id' => $dc->id, 'or' => 'cont']), ['class' => 'btn btn-link']);
                        
                    }

                    
                    return $docente;
                }
            ],

            [
                'label' => 'Desarrollo de',
                'format' => 'raw',
                'value' => function ($model) use ($anio){
                    $ret = '';
                    try {
                        foreach ($model->desarrollos as $desarrollo) {
                            if($desarrollo->estado == 2 && $desarrollo->aniolectivo == $anio){
                                $ret .= Html::button($desarrollo->docente0->nombreCompleto, ['value' => Url::to(['view', 't' => $desarrollo->token, 'or' => 'aj']), 'title' => $desarrollo->docente0->nombreCompleto, 'class' => 'btn btn-primary amodalgenerico', 'id' => 'des'.$desarrollo->id]);
                                /*$ret .= Html::a($desarrollo->docente0->nombreCompleto, ['view', 't' => $desarrollo->token, 'or' => 'aj'], 
                                [
                                    'class' => 'label label-primary'
                                ]);*/
                                $ret .='<br />';
                            }
                        }
                    } catch (\Throwable $th) {
                        $ret = 'Sin cargar';
                    }
                   return $ret; 
                    
                    
                }
            ],
        ],
    ]); ?>
</div>