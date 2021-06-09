<?php

use app\config\Globales;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de docentes en horario';
$anios=ArrayHelper::map($anios,'id','nombre');
$anio = $model->aniolectivo;
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
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'label' =>'Documento',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->documento;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            [
                'label' =>'Docente',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->apellido.', '.$dc->agente0->nombre;
                            break;
                        }
                    }
                    return $doc;
                }
            ],

            [
                'label' =>'Materia',
                //'group' => true,
                'attribute' => 'actividad0.nombre',
            ],
           
            [
                'label' => 'División',
                //'group' => true,
                'format' => 'raw',
                'value' => function($model){
                        
                            return $model->division0->nombre;
                         
                }

            ],

            [
                'label' =>'Mail',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    foreach ($cat->detallecatedras as $dc) {
                        if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                            $doc = $dc->agente0->mail;
                            break;
                        }
                    }
                    return $doc;
                }
            ],
            /*[
                'label' =>'Cantidad de horas 2020',
                //'group' => true,
                'value' => function($model) use($anio){
                    $cat = $model;
                    $c = 0;
                    foreach ($cat->horarios as $horario) {
                        if ($horario->aniolectivo==$anio){
                            $c++;
                        }
                    }
                    return $c;
                }
            ],*/

            [
                'class' => 'kartik\grid\ActionColumn',

                'template' => '{viewdetcat}',
                'visible' => (in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA])) ? true : false,
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key) use($anio){
                        $cat = $model;
                        foreach ($cat->detallecatedras as $dc) {
                            if ($dc->revista == 6 && $dc->aniolectivo==$anio){
                                $id = $dc->id;
                                break;
                            }
                        }
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=detallecatedra/updatehorario&or=lh&id='.$id);
                    },
                    
                    'dj' => function($url, $model, $key){
                        return Html::button('<span class="glyphicon glyphicon-modal-window"></span>',
                        ['value' => Url::to('index.php?r=horario/declaracionhorario&dni='.$model->agente0->documento),
                            'class' => 'modala btn btn-link', 'id'=>'modala']);
                            
                    },

                    'updatedetcat' => function($url, $model, $key){
                    
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                        ['value' => Url::to('index.php?r=detallecatedra/updatehorario&id='.$model['id']),
                            'class' => 'modala btn btn-link', 'id'=>'modala']);


                },
                    
                    
                ]

            ]
            
            
            /*[
                'label' =>'',
                'group' => true,
                'attribute' => 'diasemana0.nombre',
            ],
            [
                'label' =>'',
                'attribute' => 'hora0.nombre',
            ],*/
            
            //'tipomovilidad0.nombre',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>