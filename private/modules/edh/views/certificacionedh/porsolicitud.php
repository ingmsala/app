<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\edh\models\CertificacionedhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<div class="certificacionedh-index">

<ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" <?php echo 'href="#certificados'.$solicitud.'"'?>>Certificados</a></li>
          <li><a data-toggle="tab" <?php echo 'href="#informes'.$solicitud.'"'?>>Informes profesionales</a></li>
          
          
        </ul>

        <div class="tab-content">
            <div <?php echo 'id="certificados'.$solicitud.'"'?> class="tab-pane fade in active">
    
                <p style="margin-top:1em" class="pull-right">
                <?= Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Agregar certificado', ['value' => Url::to('index.php?r=edh/certificacionedh/create&solicitud='.$solicitud), 'class' => 'btn btn-success amodalcertificado']); ?>
                </p>

                <div class="clearfix"></div>
                <?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'summary' => false,
                    'responsiveWrap' => false,
                    'bordered' => false,
                    'columns' => [
                        
                        [
                            'label' => 'Fecha',
                            'format' => 'raw',
                            'value' => function($model){
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                
                                //return Html::button(Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy'), Url::to([]));
                                return Html::button(Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy'),
                                    ['value' => Url::to(['certificacionedh/update', 'id' => $model->id]),
                                    'class' => 'amodalcertificado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                            }
                        ],
                        [
                            'label' => 'Referente',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::button($model->referente,
                                    ['value' => Url::to(['certificacionedh/update', 'id' => $model->id]),
                                    'class' => 'amodalcertificado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                                
                            }
                        ],
                        [
                            'label' => 'Institución',
                            'format' => 'raw',
                            'value' => function($model){
                                
                                return Html::button($model->institucion,
                                ['value' => Url::to(['certificacionedh/update', 'id' => $model->id]),
                                'class' => 'amodalcertificado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                            }
                        ],
                        
                        [
                            'label' => 'Vencimiento',
                            'format' => 'raw',
                            'value' => function($model){
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                
                                return Html::button(Yii::$app->formatter->asDate($model->vencimiento, 'dd/MM/yyyy'),
                                ['value' => Url::to(['certificacionedh/update', 'id' => $model->id]),
                                'class' => 'amodalcertificado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
                            }
                        ],
                        //'diagnostico',            
                        //'tipocertificado0.nombre',
                        //'tipoprofesional0.nombre',
                        //'indicacion:ntext',
                        [
                            'label' => 'Adjuntos',
                            'format' => 'raw',
                            'value' => function($model){

                                


                                //$echofooter = '<ul style="padding-inline-start: 0px;">';
                                $echofooter = '';
                                
                                foreach ($model->adjuntocertificacions as $adjunto) {

                                    $len = (Yii::$app->params['devicedetect']['isMobile']) ? 15 : 20;

                                    if(strlen($adjunto->nombre)>$len){
                                        
                                        $arr = explode(".", $adjunto->nombre);
                                        $ext = end($arr);
                                        $img = substr(ltrim($adjunto->nombre),0,$len).'...'.$ext;
                        
                        
                                    }else
                                        $img = $adjunto->nombre;


                                        if($adjunto->certificacion0->solicitud0->caso0->estadocaso == 2){
                                            $echofooter .= '<div class="label label-default" style="border-style: solid;border-width: 1px;border-radius: 5px;">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntocertificacion/descargar', 'file' => $adjunto->url]), ['target'=>'_blank', 'data-pjax'=>"0"]).' '.
                                         '</div><div class="clearfix"></div>';  
                                        }else{
                                            $echofooter .= '<div class="label label-default" style="border-style: solid;border-width: 1px;border-radius: 5px;">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntocertificacion/descargar', 'file' => $adjunto->url]), ['target'=>'_blank', 'data-pjax'=>"0"]).' '.
                                          Html::button('<span class="glyphicon glyphicon-remove"></span>',['value' => $adjunto->id, 
                                          
                                         'class' => 'deletebuttonadjuntocert btn btn-link',
                                         'style' => 'width:auto;margin:0.6em;position:relative;padding: 0px;',
                                         //'data-confirm' => Yii::t('yii', 'Desea eliminar este elemento??'),
                                         /*'data' => [
                                            'confirm' => '¿Está seguro de querer eliminar este elemento?',
                                            'method' => 'post',
                                            ]*/
                                         ]).'</div><div class="clearfix"></div>';  
                                        }
                                    
                                        //$echofooter .= '<li style="list-style:none">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntocertificacion/descargar', 'file' => $adjunto->url]), ['target'=>'_blank']).'</li>';
                                          
                                        
                                    
                                }
                                //$echofooter .= '</ul>';
                                return $echofooter;
                            }
                        ],

                        /*[
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{update}',
                            'buttons' => [
            
                                'update' => function($url, $model, $key){
                                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['value' => Url::to(['certificacionedh/update', 'id' => $model->id]),
                                            'class' => 'amodalcertificado btn btn-link', 'style'=>'width:auto;margin-bottom:0px;']);
            
            
                                },
                                
                                'delete' => function($url, $model, $key){
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['certificacionedh/delete', 'id' => $model->id]), 
                                        ['data' => [
                                        'confirm' => 'Está seguro de querer eliminar este elemento?',
                                        'method' => 'post',
                                         ]
                                        ]);
                                },
            
                            ]
                        
                        ],*/

                    ],
                ]); ?>
                <?php Pjax::end() ?>
            </div>

            <div <?php echo 'id="informes'.$solicitud.'"'?> class="tab-pane fade">
            <?php 

                echo $this->render('/informeprofesional/index', [
                    'searchModel' => $searchModelInforme,
                    'dataProvider' => $dataProviderInforme,
                    'solicitud' => $solicitud,
                ]);

            ?>
            

          </div>
        </div>
</div>
